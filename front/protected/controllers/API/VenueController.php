<?php

class VenueController extends Controller
{
    public function actionList()
    {
        // Get artists
        $venues = Venue::getList();

        // Validate user input and redirect to the previous page if valid
        if ($venues) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $venues
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Could not find any records, please check filter'
            );
        }

        $this->renderJSON($result);
    }
}