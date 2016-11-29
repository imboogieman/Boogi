<?php


class SystemCommand extends Command
{
    public function actionUpdateVenues()
    {
        $this->actionMergeVenues();
        $this->actionCleanVenues();
    }

    public function actionMergeVenues()
    {
        $merged = Venue::merge();
        Command::info($merged . ' venues merged');
        return 0;
    }

    public function actionCleanVenues()
    {
        $cleaned = Venue::clean();
        Command::info($cleaned . ' venues cleaned');
        return 0;
    }

    public function actionValidateObjects()
    {
        $this->actionValidateArtists();
        $this->actionValidateVenues();
        $this->actionValidateEvents();
    }

    public function actionValidateEvents()
    {
        return $this->_updateRecords(Event::model());
    }

    public function actionValidateVenues()
    {
        return $this->_updateRecords(Venue::model());
    }
    
    public function actionValidateArtists()
    {
        return $this->_updateRecords(Artist::model());
    }

    public function actionUpdateAliases()
    {
        $artists = $promoters = $gigs = $venues = 0;

        $records = Artist::model()->findAll();
        foreach ($records as $record) {
            $artists += $record->generateAlias() ? 1 : 0;
        }

        $records = Promoter::model()->findAll();
        foreach ($records as $record) {
            $promoters += $record->generateAlias() ? 1 : 0;
        }

        $records = Gig::model()->findAll();
        foreach ($records as $record) {
            $gigs += $record->generateAlias() ? 1 : 0;
        }

        $records = Venue::model()->findAll();
        foreach ($records as $record) {
            $venues += $record->generateAlias() ? 1 : 0;
        }

        Command::info('Updated aliases a:' . $artists . ', p:' . $promoters . ', g:' . $gigs . ', v:' . $venues);
        return 0;
    }

    public function actionSyncEventArtistAliases()
    {
        // Get artists and create update dictionary
        $artists = array();
        foreach (Artist::model()->findAll() as $artist) {
            $artists[$artist->id] = $artist->alias;
        }

        // Get events with artist
        $events = Event::model()->findAll(array(
            'condition' => 'init_type = :type OR target_type = :type OR creator_type = :type',
            'params'    => array(
                ':type'     => 'Artist',
            )
        ));

        // And update it
        $updated = $deleted = 0;
        foreach ($events as $event) {

            if ($event->init_type == 'Artist') {
                if (!isset($artists[$event->init_id])) {
                    $deleted += $event->delete() ? 1 : 0;
                    continue;
                }
                $event->init_link = '/' . $artists[$event->init_id];
            }

            if ($event->target_type == 'Artist') {
                if (!isset($artists[$event->target_id])) {
                    $deleted += $event->delete() ? 1 : 0;
                    continue;
                }
                $event->target_link = '/' . $artists[$event->target_id];
            }

            if ($event->creator_type == 'Artist') {
                if (!isset($artists[$event->creator_id])) {
                    $deleted += $event->delete() ? 1 : 0;
                    continue;
                }
                $event->creator_link = '/' . $artists[$event->creator_id];
            }

            $updated += $event->save() ? 1 : 0;
        }

        Command::info($updated . ' event(s) updated, ' . $deleted . ' deleted');
        return 0;
    }

    public function actionDeleteGhostImages()
    {
        // Counters
        $deleted_from_fs = $deleted_from_db = 0;

        // Routes
        $abs_path = realpath(DOC_ROOT . '/../');
        $image_path = array(
            $abs_path . '/front/images/storage/artist',
            $abs_path . '/front/images/storage/gig',
            $abs_path . '/front/images/storage/promoter',
            $abs_path . '/front/images/storage/temp',
            $abs_path . '/front/images/storage/venue',
        );


        // Get all files on disk
        $fs_files = array();
        foreach ($image_path as $path) {
            $fs_files = array_merge($fs_files, $this->_getDirList($path));
        }

        // Get all files from DB and delete ghosts
        $db_files = array();
        foreach (File::model()->findAll() as $file) {
            $path = realpath($abs_path . '/front/' . $file->path);
            if ($path) {
                $db_files[] = $path;
            } else {
                $deleted_from_db++;
                $file->delete();
            }
        }
        Command::info('Collected images from db:' . count($db_files) . ', from disk:' . count($fs_files));

        // Remove ghost links from disk
        $files_to_delete = array_diff($fs_files, $db_files);
        foreach ($files_to_delete as $file) {
            try {
                unlink($file);
                $deleted_from_fs++;
            } catch (Exception $e) {
                continue;
            }
        }

        Command::info('Deleted images from db:' . $deleted_from_db . ', from disk:' . $deleted_from_fs);
        return 0;
    }

    public function actionUpdateEventGigDates()
    {
        // Update event gig dates
        $events = Yii::app()->db->createCommand("
            UPDATE `event` AS e
            SET e.`datetime` = (SELECT g.`datetime_from` FROM `gig` AS g WHERE g.`id` = e.`target_id`)
            WHERE e.`target_type` = 'Gig';
        ")->queryAll();

        Command::info('Events updated: ' . $events);
        return 0;
    }

    public function actionCreatePromoterEmailRecords()
    {
        $created = 0;
        $users = User::model()->findAll(array(
            'condition' => 'role = :role',
            'params'    => array(':role' => User::ROLE_PROMOTER)
        ));

        foreach ($users as $user) {
            $user_email = new UserEmail;
            $user_email->user_id = $user->id;
            $created += $user_email->save() ? 1 : 0;
        }

        Command::info('Promoters: ' . count($users) . ', email records created: ' . $created);
        return 0;
    }
}
