<?php
/**
 * Raw Message Api Model
 */

class MessageApi
{
    /**
     * Get artist list
     * @param int $gig_id
     * @param int $artist_id
     * @return array
     */
    public static function getList($gig_id, $artist_id)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Get messages
        $messages = Yii::app()->db->createCommand("
            SELECT m.message, m.type, m.timestamp
            FROM message m
            WHERE m.gig_id = " . $gig_id . "
              AND m.artist_id = " . $artist_id . "
        ")->queryAll();

        // Compile result
        $result = array();
        if ($messages) {
            foreach ($messages as $message) {
                $result[] = array(
                    'type'      => Message::getTypeById($message['type']),
                    'message'   => $message['message'],
                    'date'      => date('Y-m-d', strtotime($message['timestamp'])),
                    'time'      => date('H:i', strtotime($message['timestamp']))
                );
            }
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    /**
     * Get artist list
     * @param int $gig_id
     * @param int $artist_id (optional)
     * @return array
     */
    public static function getGigLog($gig_id, $artist_id = null)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Check artist ID
        $where = $artist_id ? 'm.gig_id = ' . $gig_id . ' AND m.artist_id = ' . $artist_id :  'm.gig_id = ' . $gig_id;

        // Get messages
        $messages = Yii::app()->db->createCommand("
            SELECT m.message, m.type, m.timestamp
            FROM message m
            WHERE  " . $where . "
            GROUP BY m.message
            ORDER BY m.timestamp DESC
        ")->queryAll();

        // Compile result
        $result = array();
        if ($messages) {
            foreach ($messages as $message) {
                if ($message['type'] == Message::TYPE_PROMOTER_MESSAGE || $message['type'] == Message::TYPE_ARTIST_MESSAGE)
                    continue;

                $result[] = array(
                    'message'   => $message['message'],
                    'date'      => date('d.m.Y', strtotime($message['timestamp'])),
                    'time'      => date('h:i:s A', strtotime($message['timestamp']))
                );
            }
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    /**
     * Add message
     * @param array $data
     * @return bool
     */
    public static function add($data)
    {
        // Check required
        if (!$data['type'] || !$data['gig_id'] || !$data['artist_id']) {
            return false;
        }

        // Clean all artist caches
        Cache::clean(Cache::MESSAGE_NS);

        // Insert new message
        return Yii::app()->db->createCommand("
            INSERT INTO message (type, gig_id, artist_id, message)
            VALUES (" . $data['type'] . ", " . $data['gig_id'] . ", " . $data['artist_id'] . ", '" . $data['message'] . "');
        ")->execute();
    }

    public static function addConfirmMessageToArtist($gig_id, $artist_id, $user)
    {
        return MessageApi::add(array(
            'type'      => Message::TYPE_PROMOTER_UPDATE,
            'gig_id'    => $gig_id,
            'artist_id' => $artist_id,
            'message'   => $user->promoter()->name . ' confirmed your booking',
        ));
    }

    public static function addAcceptMessageToPromoter($gig_id, $artist_id, $user)
    {
        return MessageApi::add(array(
            'type'      => Message::TYPE_ARTIST_UPDATE,
            'gig_id'    => $gig_id,
            'artist_id' => $artist_id,
            'message'   => $user->artist()->name . ' accepted your booking',
        ));
    }

    public static function addRejectMessage($gig_id, $artist_id, $user)
    {
        $name = $user->is_promoter() ? $user->promoter()->name : $user->artist()->name;
        return MessageApi::add(array(
            'type'      => $user->is_promoter() ? Message::TYPE_PROMOTER_UPDATE : Message::TYPE_ARTIST_UPDATE,
            'gig_id'    => $gig_id,
            'artist_id' => $artist_id,
            'message'   => $name . ' rejected your booking',
        ));
    }
}