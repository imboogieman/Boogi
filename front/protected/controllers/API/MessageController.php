<?php

class MessageController extends Controller
{
    public function actionGet()
    {
        // Get request
        $request = Yii::app()->request;
        $gig_id = $request->getPost('gig_id');
        $artist_id = $request->getPost('artist_id');

        // Get messages for gig
        $messages = MessageApi::getList($gig_id, $artist_id);
        if ($messages) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $messages
            );
        } else {
            $result = array(
                'result'    => ApiStatus::NO_RECORDS,
                'message'   => 'Could not find any records, please check filter'
            );
        }

        $this->renderJSON($result);
    }

    public function actionAdd()
    {
        // Get request
        $request = Yii::app()->request;
        $data = array(
            'type'      => (int)$request->getPost('type'),
            'gig_id'    => (int)$request->getPost('gig_id'),
            'artist_id' => (int)$request->getPost('artist_id'),
            'message'   => strip_tags($request->getPost('message')),
        );

        // Try to save
        if (MessageApi::add($data)) {
            // Send confirm messages
            if ($data['type'] == Message::TYPE_ARTIST_MESSAGE) {
                Mailer::sendBookingMessageEmailToPromoter($data);
            }
            if ($data['type'] == Message::TYPE_PROMOTER_MESSAGE) {
                Mailer::sendBookingMessageEmailToArtist($data);
            }

            // Clean messages caches
            Cache::clean(Cache::MESSAGE_NS);

            // Return result
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => MessageApi::getList($data['gig_id'], $data['artist_id'])
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Could not add record, please try later'
            );
        }

        $this->renderJSON($result);
    }
}