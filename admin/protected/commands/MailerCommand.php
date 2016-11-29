<?php


class MailerCommand extends Command
{
    const EMAIL_MAX_EXECUTION_TIME = 55;

    /**
     * Email queue for events
     * @return int
     */
    public function actionSendEventEmails()
    {
        $start_time = time();
        $sent = 0;

        // Get not sent events
        $events = Event::model()->findAll(array(
            'condition' => 'email_status = :email_status AND email_attempts < :max_attempts AND type <> :type',
            'params'    => array(
                ':email_status' => Event::EMAIL_NOT_SENT,
                ':max_attempts' => Event::EMAIL_MAX_SEND_ATTEMPTS,
                ':type'         => Event::ARTIST_CREATE,
            ),
            'order'     => 'id ASC',
            'group'     => 'init_id, init_type, timestamp'
        ));

        // Merge and try to send emails
        foreach ($this->_mergeEvents($events) as $event) {
            $eventEmail = new EventEmail($event);
            $sent += $eventEmail->send() ? 1 : 0;

            // Check execution time to prevent overheads
            if (time() > $start_time + self::EMAIL_MAX_EXECUTION_TIME) {
                break;
            }
        }

        Command::info($sent . ' Event email(s) sent');
        return 0;
    }

    /**
     * Merge events for each user
     * @param Event[] $events
     * @return mixed
     */
    protected function _mergeEvents($events)
    {
        // Defaults
        $allowedEventTypes = array(Event::GIG_CREATE, Event::ARTIST_TRACK);
        $mergedEvents = array();

        // Process events
        foreach ($events as $event) {
            if (in_array($event->type, $allowedEventTypes)) {
                $index = date('Y-m-d', strtotime($event->timestamp)) . $event->creator_id;
                if (isset($mergedEvents[$index])) {
                    $mergedEvents[$index]['events'][] = $event;
                } else {
                    $mergedEvents[$index] = array(
                        'is_merged' => true,
                        'events'    => array($event)
                    );
                }
            } else {
                $mergedEvents[$event->id] = $event;
            }
        }

        Command::info(count($mergedEvents) . ' Event(s) after merge');
        return $mergedEvents;
    }

    public function actionSendPromoterRetentionEmails($is_long = false)
    {
        if ($is_long) {
            $where = 'retention_14_sent';
            $created_date = date('Y-m-d', strtotime('-1 day'));
        } else {
            $where = 'retention_sent';
            $created_date = date('Y-m-d', strtotime('-2 week'));
        }

        $users = Yii::app()->db->createCommand("
            SELECT u.id, u.email, p.name
            FROM user u
            JOIN user_email um ON u.id = um.user_id
            JOIN promoter p ON u.id = p.user_id
            LEFT JOIN gig g ON u.id = g.user_id
            LEFT JOIN artist_promoter ap ON p.id = ap.promoter_id
            WHERE u.role = 1
             AND um." . $where . " = 0
             AND u.created_date < '" . $created_date . "'
            GROUP BY u.id
            HAVING COUNT(g.id) = 0
              AND COUNT(ap.id) = 0;"
        )->queryAll();

        $sent = 0;
        foreach ($users as $user) {
            $data = array(
                'email' => $user['email'],
                'name'  => $user['name']
            );

            // Update current user
            $result = $is_long ? Mailer::sendRetention14Email($data) : Mailer::sendRetentionEmail($data);
            if ($result) {
                $sent++;
                Yii::app()->db->createCommand("
                    UPDATE user_email
                    SET " . $where . " = 1
                    WHERE user_id = " . $user['id'] . ";
                ")->execute();
            }
        }

        Command::info($sent . ' Retention email(s) sent');
        return 0;
    }

    // @TODO: Decrease Cyclomatic complexity, NPath complexity
    public function actionSendPeriodicEmails($check_radius = false)
    {

        if ($check_radius) {
            $email_template_id = MCMDBridge::PROMOTER_GIG_IN_RADIUS;
            $where = "g.datetime_from > NOW()
              AND v.latitude <> 0
              AND v.longitude <> 0
              AND p.latitude <> 0
              AND p.longitude <> 0
              AND p.radius <> 0";
        } else {
            $email_template_id = MCMDBridge::PROMOTER_FOLLOWERS;
            $where = "g.datetime_from > NOW()";
        }

        $data = Yii::app()->db->createCommand("
            SELECT g.id AS gig_id, g.name AS gig_name, g.alias AS gig_alias, g.datetime_from AS date, g.address AS address,
              a.id AS artist_id, a.fb_id as fb_id, a.name AS artist_name, a.alias AS artist_alias,
              v.latitude AS venue_lat, v.longitude AS venue_lon,
              p.id AS promoter_id, p.name AS promoter_name, u.email AS promoter_email,
              p.latitude AS promoter_lat, p.longitude AS promoter_lon, p.radius AS promoter_radius,
              u.id AS user_id, u.email, ag1.gig_id AS marker
            FROM gig g
            JOIN venue v ON g.venue_id = v.id
            JOIN artist_gig ag ON g.id = ag.gig_id
            JOIN artist a ON ag.artist_id = a.id
            LEFT JOIN artist_gig ag1 ON
            a.id = ag1.artist_id
            AND DATE(ag1.datetime_from) = DATE(DATE_ADD(g.datetime_from, INTERVAL 3 DAY))
            AND DATE(ag1.datetime_from) = DATE(DATE_ADD(g.datetime_from, INTERVAL 2 DAY))
            AND DATE(ag1.datetime_from) = DATE(DATE_ADD(g.datetime_from, INTERVAL 1 DAY))
            AND DATE(ag1.datetime_from) = DATE(SUBDATE(g.datetime_from, 3))
            AND DATE(ag1.datetime_from) = DATE(SUBDATE(g.datetime_from, 2))
            AND DATE(ag1.datetime_from) = DATE(SUBDATE(g.datetime_from, 1))
            JOIN artist_promoter ap ON a.id = ap.artist_id
            JOIN promoter p ON ap.promoter_id = p.id
            JOIN user u ON p.user_id = u.id
            WHERE " . $where . "
              AND p.is_approved = 1
              AND ag1.gig_id IS NULL
              AND ag.timestamp > SUBDATE(NOW(), 1)
              AND DATE(g.datetime_from) < DATE(DATE_ADD(NOW(), INTERVAL 11 DAY))
            ORDER BY g.datetime_from ASC;"
        )->queryAll();

        $result = array();
        foreach ($data as $key => $item) {

            // Check already sent notifications
            $options = Mailer::getMailOptions( $item['email'], $email_template_id );
            if ( array_key_exists( $item['gig_id'], $options ) && in_array( $item['artist_id'],
                    $options[ $item['gig_id'] ] )
            ) {
                continue;
            }
            $distance = 0;
            // Check distance
            if ( $check_radius ) {
                $distance = Model::getDistance( $item['venue_lat'], $item['venue_lon'],
                    $item['promoter_lat'], $item['promoter_lon'] );
                $radius   = $item['promoter_radius'] / 1000;
                if ( is_nan( $distance ) || bccomp( $distance, $radius ) == 1 ) {
                    continue;
                }
            }

            $boogiLink = Yii::app()->params['baseUrl'] . $item['artist_alias'];
            $distR     = round( $distance, 2 );
            $location  = empty( $item['address'] ) ? "" : "in $item[address]";
            $date      = date( 'D, d M Y', strtotime( $item['date'] ) );
            $gig       = "<strong>$item[artist_name]</strong> is performing<br>
$date $location<br>
($distR km from you),<br>
so you can <a href=\"$boogiLink\" target=\"_blank\">book</a><br>
or contact via <a href=\"https://www.facebook.com/profile.php?id=$item[fb_id]\" target=\"_blank\">facebook</a>.";

            // Add new notifications
            if ( isset( $result[ $item['promoter_id'] ] ) ) {
                if ($result[ $item['promoter_id'] ]['count'] < 9 ) {
                    $result[ $item['promoter_id'] ]['gigs'] .= "<br><br>" . $gig;
                    $result[ $item['promoter_id'] ]['count'] += 1;
                }
            } else {
                $result[ $item['promoter_id'] ] = array(
                    'name'  => $item['promoter_name'],
                    'email' => $item['promoter_email'],
                    'gigs'  => $gig,
                    'count' => 0
                );
            }

        }

        $sent = 0;
        foreach ($result as $item) {
//            if ($this->hasGigs($item['gigs'])) {
                $send_result = $check_radius ? Mailer::sendGigInRadiusEmail($item) : Mailer::sendFollowedEmail($item);
                $sent += $send_result ? 1 : 0;
//            }
        }

        Command::info($sent . ' Periodic email(s) sent');
        return 0;
    }

    private function hasGigs($gigs)
    {
        foreach ($gigs as $item) {
            if (count($item)) {
                return true;
            }
        }
        return false;
    }

    public function actionSyncMailChimpTemplates()
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $synced = 0;
            $mc = new Mailchimp(Yii::app()->params['mcApiKey']);
            $list = $mc->templates->getList(array(), array('include_drag_and_drop' => true));
            foreach ($list['user'] as $template) {
                $tmp = MailchimpTemplate::getOrCreateBySourceId($template['id']);
                $tmp->source_id = $template['id'];
                $tmp->folder_id = $template['folder_id'];
                $tmp->name = $template['name'];
                $tmp->category = $template['category'];
                $tmp->layout = $template['layout'];
                $tmp->preview_image = $template['preview_image'];
                $tmp->date_created = $template['date_created'];
                $tmp->active = (int)$template['active'];
                $tmp->save();
                $synced++;
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Command::error($e->getMessage());
            return -1;
        }

        Command::info($synced .' MailChimp template(s) synced');
        return 0;
    }

    public function actionSyncMandrillTemplates()
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $md = new Mandrill(Yii::app()->params['mdApiKey']);
            $list = $md->templates->getList();
            foreach ($list as $template) {
                $tmp = MandrillTemplate::getOrCreateBySlug($template['slug']);
                $tmp->slug = $template['slug'];
                $tmp->name = $template['name'];
                $tmp->labels = implode(',', $template['labels']);
                $tmp->code = $template['code'];
                $tmp->subject = $template['subject'];
                $tmp->from_email = $template['from_email'];
                $tmp->from_name = $template['from_name'];
                $tmp->text = $template['text'];
                $tmp->publish_name = $template['publish_name'];
                $tmp->publish_code = $template['publish_code'];
                $tmp->publish_subject = $template['publish_subject'];
                $tmp->publish_from_email = $template['publish_from_email'];
                $tmp->publish_from_name = $template['publish_from_name'];
                $tmp->publish_text = $template['publish_text'];
                $tmp->published_at = $template['published_at'];
                $tmp->created_at = $template['created_at'];
                $tmp->updated_at = $template['updated_at'];
                $tmp->save();
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Command::error($e->getMessage());
            return -1;
        }

        Command::info(count($list) .' Mandrill template(s) synced');
        return 0;
    }
}
