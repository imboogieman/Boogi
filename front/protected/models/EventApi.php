<?php
/**
 * Raw Event Api Model
 */

class EventApi
{
    /**
     * Aupdate virtual account events
     * @param array $data
     * @return bool
     */
    public static function updateAccount($data)
    {
        // Update and return result
        return Yii::app()->db->createCommand("
            UPDATE `event`
            SET `init_name` = '" . $data['name'] . "', `init_link` = '" . $data['link'] . "'
            WHERE `init_type` = 'Promoter'
              AND `init_id` = " . $data['id'] . ";
        ")->execute();
    }

    /**
     * Create update events for Gig
     * @param array $old
     * @param array $new
     * @param Promoter $promoter
     * @return bool
     */
    public static function createGigUpdateEvents($old, $new, $promoter)
    {
        // Check user
        if (!$promoter) {
            return false;
        }
        // Check gig
        if (!$gig = Gig::model('Gig')->findByPk($new['id'])) {
            return false;
        }

        // Suppress previous active events
        Yii::app()->db->createCommand("
            UPDATE `event`
            SET `is_active` = 0
            WHERE `target_type` = 'Gig'
              AND `target_id` = " . $gig->id . ";
        ")->execute();

        // Insert event
        $insert = array(
            'type'          => Event::PROMOTER_GIG_UPDATE,
            'init_type'     => Yii::app()->db->quoteValue('Promoter'),
            'init_id'       => $promoter->id,
            'init_name'     => Yii::app()->db->quoteValue($promoter->name),
            'init_link'     => Yii::app()->db->quoteValue($promoter->getLink(User::ROLE_ARTIST)),
            'target_type'   => Yii::app()->db->quoteValue('Gig'),
            'target_id'     => $gig->id,
            'target_name'   => Yii::app()->db->quoteValue($gig->name),
            'target_link'   => Yii::app()->db->quoteValue($gig->getLink()),
            'datetime'      => Yii::app()->db->quoteValue(date('Y-m-d H:i:s')),
            'is_active'     => 1
        );

        // Compile data
        $data = array();
        $check = array('name', 'description', 'datetime_from', 'datetime_to', 'type', 'capacity', 'venue_id');
        foreach ($new as $field => $value) {
            if ($old[$field] != $value && in_array($field, $check)) {
                $data[] = array(
                    'field'     => $field,
                    'new_value' => $value,
                    'old_value' => empty($old[$field]) || $old[$field] == 'Not set' ? '' : $old[$field],
                );
            }
        }
        $insert['data'] = Yii::app()->db->quoteValue(json_encode($data));

        // Insert Event data for each booking user
        $insert_list = array();
        foreach ($new['bookings'] as $booking) {
            $insert['creator_type'] = Yii::app()->db->quoteValue('Artist');
            $insert['creator_id'] = $booking['artist_id'];
            $insert['creator_name'] = Yii::app()->db->quoteValue($booking['artist_name']);
            $insert['creator_link'] = Yii::app()->db->quoteValue('/' . $booking['artist_alias']);
            $insert_list[] = implode(',', array_values($insert));
        }

        return Yii::app()->db->createCommand("
            INSERT INTO `event` (" . implode(',', array_keys($insert)) . ")
            VALUES (" . implode('),(', $insert_list) . ");
        ")->execute();
    }

    /**
     * Create update events for ArtistGig
     * @param array $old
     * @param array $new
     * @param User $user
     * @return bool
     */
    public static function createBookingUpdateEvents($old, $new, $user)
    {
        // Check artist gig
        if (!$artistGig = ArtistGig::model('ArtistGig')->findByPk($new['id'])) {
            return false;
        }

        // Check user
        if ($user->role == User::ROLE_PROMOTER) {
            $type = Event::PROMOTER_BOOKING_UPDATE;
            $init_type = 'Promoter';
            if (!$creator = $user->promoter()) {
                return false;
            }

            $creator_id = $artistGig->artist->id;
            $creator_name = $artistGig->artist->name;
            $creator_link = $artistGig->artist->getLink();
            $creator_type = 'Artist';
        } else {
            $type = Event::ARTIST_BOOKING_UPDATE;
            $init_type = 'Artist';
            if (!$creator = $user->artist()) {
                return false;
            }

            $creator_id = $artistGig->gig->user->promoter()->id;
            $creator_name = $artistGig->gig->user->promoter()->name;
            $creator_link = $artistGig->gig->user->promoter()->getLink();
            $creator_type = 'Promoter';
        }

        // Suppress previous active events
        Yii::app()->db->createCommand("
            UPDATE `event`
            SET `is_active` = 0
            WHERE `target_type` = 'ArtistGig'
              AND `target_id` = " . $artistGig->id . ";
        ")->execute();

        // Insert event
        $insert = array(
            'type'          => $type,
            'init_type'     => Yii::app()->db->quoteValue($init_type),
            'init_id'       => $creator->id,
            'init_name'     => Yii::app()->db->quoteValue($creator->name),
            'init_link'     => Yii::app()->db->quoteValue($creator->getLink()),
            'target_type'   => Yii::app()->db->quoteValue('ArtistGig'),
            'target_id'     => $artistGig->id,
            'target_name'   => Yii::app()->db->quoteValue($artistGig->artist->name),
            'target_link'   => Yii::app()->db->quoteValue($artistGig->getLink($user->role)),
            'creator_type'  => Yii::app()->db->quoteValue($creator_type),
            'creator_id'    => $creator_id,
            'creator_name'  => Yii::app()->db->quoteValue($creator_name),
            'creator_link'  => Yii::app()->db->quoteValue($creator_link),
            'datetime'      => Yii::app()->db->quoteValue(date('Y-m-d H:i:s')),
            'is_active'     => 1
        );

        // Compile data
        $data = array();
        $check = array('price', 'currency_id', 'accommodation_id', 'transfer_id', 'datetime_from', 'datetime_to');
        foreach ($new as $field => $value) {
            if ($old[$field] != $value && in_array($field, $check)) {
                $data[] = array(
                    'field'     => $field,
                    'new_value' => $value,
                    'old_value' => empty($old[$field]) || $old[$field] == 'Not set' ? '' : $old[$field],
                );
            }
        }
        $insert['data'] = Yii::app()->db->quoteValue(json_encode($data));

        // Insert Event data
        return Yii::app()->db->createCommand("
            INSERT INTO `event` (" . implode(',', array_keys($insert)) . ")
            VALUES (" . implode(',', array_values($insert)) . ");
        ")->execute();
    }
}