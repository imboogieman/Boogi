<?php

class LiveData extends CApplicationComponent
{
    public static function get()
    {
        $result = array(
            'events' => LiveData::getActiveEvents()
        );
        return $result;
    }

    private static function getActiveEvents($limit = 10)
    {
        $result = array();
        if (!$user = User::getLogged()) {
            return $result;
        }

        if ($user->role == User::ROLE_PROMOTER) {
            if ($user->promoter()) {
                $result = Yii::app()->db->createCommand("
                    SELECT e.*
                    FROM event e
                    JOIN artist_gig ag ON ag.id = e.target_id
                    WHERE e.type = " . Event::ARTIST_BOOKING_UPDATE . "
                      AND e.is_active = 1
                      AND e.creator_type = 'Promoter'
                      AND e.creator_id = " . $user->promoter()->id . "
                      AND ag.datetime_from >= NOW()
                    LIMIT " . $limit . ";
                ")->queryAll();
            }
        } else {
            if ($user->artist()) {
                $result = Yii::app()->db->createCommand("
                    SELECT e.*
                    FROM event e
                    JOIN artist_gig ag ON ag.id = e.target_id
                    WHERE e.type IN (" . Event::PROMOTER_GIG_UPDATE . "," . Event::PROMOTER_BOOKING_UPDATE . ")
                      AND e.is_active = 1
                      AND e.creator_type = 'Artist'
                      AND e.creator_id = " . $user->artist()->id . "
                      AND ag.datetime_from >= NOW()
                      LIMIT " . $limit . ";
                ")->queryAll();
            }
        }

        foreach ($result as &$item) {
            $item['type_string'] = Event::getTypeById(array('type' => $item['type'], 'is_followed' => false));
        }

        return $result;
    }
}