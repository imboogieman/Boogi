<?php

class GigController extends Controller
{
    public function actionList()
    {
        // Get request params
        $request = Yii::app()->request;
        // Get all gigs
        $gigs = GigApi::filter(array(
            'from_date' => $request->getPost('from_date', date('Y-m-d')),
            'to_date'   => $request->getPost('to_date', date('Y-m-d', strtotime('+3 days'))),
        ));
        if ($gigs) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $gigs,
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Could not find any records, please check filter'
            );
        }

        $this->renderJSON($result);
    }

    public function actionGet()
    {
        // Get request
        $request = Yii::app()->request;

        // Get gig by ID
        $gig = GigApi::filter(array('id' => $request->getPost('id')));
        if ($gig) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $gig
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Could not find gig with such id'
            );
        }

        $this->renderJSON($result);
    }

    public function actionFind()
    {
        // Get request
        $request = Yii::app()->request;

        // Get gig by alias
        $gig = GigApi::filter(array('alias' => $request->getPost('alias')));
        if ($gig) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $gig
            );
        } else {
            $result = array(
                'result'    => ApiStatus::NO_RECORDS,
                'message'   => 'Could not find gig with such id'
            );
        }

        $this->renderJSON($result);
    }

    public function actionForm()
    {
        // Get request
        $request = Yii::app()->request;

        $gig = GigApi::filter(array(
            'id'        => $request->getPost('id'),
            'show_all'  => true,
            'is_active' => true
        ));

        if ($gig) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $gig
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Could not find gig with such id'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Return booking details
     * @TODO: Decrease Cyclomatic complexity
     * @TODO: Split method for submethods, decrease the number of lines
     */
    public function actionUpdate()
    {
        // Get params
        $request = Yii::app()->request;

        // Check user state
        if (!$promoter = Promoter::getLogged()) {
            $this->renderJSON(array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            ));
            return;
        }

        // Get and check general data
        $address = $request->getPost('address');
        $venue_id = $request->getPost('venue_id');
        $venue_data = \CJSON::decode($request->getPost('venue_data'));
        if (empty($venue_data) && empty($venue_id) && empty($address)) {
            $this->renderJSON(array(
                'result'    => ApiStatus::INVALID,
                'errors'    => array(
                    array('field' => 'venue', 'message' => 'Venue field is required')
                ),
                'message'   => 'Please fix errors bellow and try again'
            ));
            return;
        }

        // Create or update Venue
        $venue = Venue::getOrCreate($venue_id);
        $transaction = $venue->dbConnection->beginTransaction();

        // Update Venue data from Google
        if (empty($venue->id) || $venue->id != $venue_id) {
            if (!empty($venue_data)) {
                $venue->ds_id = $venue_data['id'];
                $venue->ds_type = DataSource::GOOGLE;

                $venue->name = isset($venue_data['name']) ? $venue_data['name'] : null;
                $venue->description = isset($venue_data['website']) ? $venue_data['website'] : null;

                if ($country = DataSource::getGoogleGCResponseValue('country', $venue_data)) {
                    if ($country = Country::getByName($country)) {
                        $venue->country_id = $country->id;
                    }
                }

                $venue->city = DataSource::getGoogleGCResponseValue('locality', $venue_data);

                $venue->address = DataSource::getGoogleGCResponseValue('route', $venue_data);
                $street_number = DataSource::getGoogleGCResponseValue('street_number', $venue_data);
                $venue->address .= $street_number ? ', ' . $street_number : '';

                $venue->latitude = DataSource::getGoogleGCResponseValue('latitude', $venue_data);
                $venue->longitude = DataSource::getGoogleGCResponseValue('longitude', $venue_data);

                if (!$venue->save()) {
                    $transaction->rollback();
                    $this->renderJSON(array(
                        'result' => ApiStatus::INVALID,
                        'errors' => array(
                            array('field' => 'venue', 'message' => 'Venue field is required')
                        ),
                        'message' => 'Please fix errors bellow and try again'
                    ));
                    return;
                }

                // Set venue ID for gig key
                $venue_id = $venue->id;
                $address = empty($address) ? $venue->address : $address;
            } elseif (!empty($address)) {
                if ($gc_result = GeoCoder::decode($address)) {
                    $venue->ds_id = $gc_result['id'];
                    $venue->ds_type = DataSource::GOOGLE;

                    if ($country = DataSource::getGoogleGCResponseValue('country', $venue_data)) {
                        if ($country = Country::getByName($country)) {
                            $venue->country_id = $country->id;
                        }
                    }

                    $venue->city = DataSource::getGoogleGCResponseValue('locality', $venue_data);

                    $venue->address = DataSource::getGoogleGCResponseValue('route', $venue_data);
                    $street_number = DataSource::getGoogleGCResponseValue('street_number', $venue_data);
                    $venue->address .= $street_number ? ', ' . $street_number : '';

                    $venue->latitude = DataSource::getGoogleGCResponseValue('latitude', $venue_data);
                    $venue->longitude = DataSource::getGoogleGCResponseValue('longitude', $venue_data);

                    if (!$venue->save()) {
                        $transaction->rollback();
                        $this->renderJSON(array(
                            'result' => ApiStatus::INVALID,
                            'errors' => array(
                                array('field' => 'venue', 'message' => 'Venue field is required')
                            ),
                            'message' => 'Please fix errors bellow and try again'
                        ));
                        return;
                    }

                    // Set venue ID for gig key
                    $venue_id = $venue->id;
                } else {
                    $transaction->rollback();
                    $this->renderJSON(array(
                        'result' => ApiStatus::INVALID,
                        'errors' => array(
                            array('field' => 'address', 'message' => 'Cant find this address, please provide more info or use venue field')
                        ),
                        'message' => 'Please fix errors bellow and try again'
                    ));
                    return;
                }
            }
        }

        // Save old data for update messages
        $gig_id = $request->getPost('id');
        $old_data = GigApi::filter(array('id' => $gig_id, 'show_all' => true));

        // Create new gig or link to existing
        $gig = Gig::getOrCreate($gig_id);

        $gig->name = $request->getPost('name');
        $gig->description = $request->getPost('description');
        $gig->venue_id = $venue_id;
        $gig->address = $address;

        $gig->datetime_from = Model::parseDateTime($request->getPost('date_from'), $request->getPost('time_from'));
        $gig->datetime_to = Model::parseDateTime($request->getPost('date_to'), $request->getPost('time_to'));
        $gig->timezone = $request->getPost('timezone');

        $gig->price = (int)$request->getPost('price');
        $gig->currency = (int)$request->getPost('currency');

        $gig->capacity = (int)$request->getPost('capacity');
        $gig->type = (int)$request->getPost('type');

        // Validate and save
        $result = $gig->validateFields();
        if ($result['result'] != ApiStatus::SUCCESS) {
            $transaction->rollback();
            $this->renderJSON($result);
            return;
        }

        if (!$gig->save()) {
            $transaction->rollback();
            $this->renderJSON(array(
                'result'    => ApiStatus::INVALID,
                'errors'    => $gig->getErrors(),
                'message'   => 'Please fix errors bellow and try again'
            ));
            return;
        }
        $transaction->commit();

        // Create update messages
        $new_data = GigApi::filter(array('id' => $gig_id, 'show_all' => true));

        // Create update events and messages
        EventApi::createGigUpdateEvents($old_data, $new_data, $promoter);

        // @TODO: Deprecated and must be replaced with Events
        GigApi::createUpdateMessages($old_data, $new_data, $promoter);

        // Clean gig caches
        Cache::clean(Cache::GIG_NS);

        // Compile result and return
        $result = array(
            'result' => ApiStatus::SUCCESS,
            'data' => PromoterApi::getGigs($promoter->id)
        );
        $this->renderJSON($result);
    }

    /**
     * Return booking details
     */
    public function actionUpdateBooking()
    {
        // Get params
        $request = Yii::app()->request;
        $id = (int)$request->getPost('id');
        $gig_id = (int)$request->getPost('gig_id');
        $artist_id = (int)$request->getPost('artist_id');

        // Check user state
        if (!$user = User::getLogged()) {
            $this->renderJSON(array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            ));
            return;
        }

        // Get old data
        $old_data = BookingApi::filter(array(
            'gig_id'        => $gig_id,
            'artist_id'     => $artist_id,
            'is_promoter'   => $user->is_promoter(),
            'show_all'      => true
        ));

        // Get booking and connection
        $artistGig = ArtistGig::getOrCreate($id);
        $transaction = $artistGig->dbConnection->beginTransaction();

        // Update booking data
        $artistGig->datetime_from = Model::parseDateTime($request->getPost('date_from'), $request->getPost('time_from'));
        $artistGig->datetime_to = Model::parseDateTime($request->getPost('date_to'), $request->getPost('time_to'));
        $artistGig->timezone = $request->getPost('timezone');

        $artistGig->price = (int)$request->getPost('price');
        $artistGig->currency = $request->getPost('currency');
        $artistGig->revenue_share = (int)$request->getPost('revenue_share');

        $artistGig->accommodation = (int)$request->getPost('accommodation');
        $artistGig->transfer = (int)$request->getPost('transfer');
        $artistGig->last_changed = $user->role;

        // Validate and save
        $result = $artistGig->validateFields();
        if ($result['result'] != ApiStatus::SUCCESS) {
            $transaction->rollback();
            $this->renderJSON($result);
            return;
        }

        if (!$artistGig->save()) {
            $transaction->rollback();
            $this->renderJSON(array(
                'result'    => ApiStatus::INVALID,
                'errors'    => $artistGig->getErrors(),
                'message'   => 'Please fix errors bellow and try again'
            ));
            return;
        }
        $transaction->commit();

        // Create update messages
        $new_data = BookingApi::filter(array(
            'gig_id'        => $gig_id,
            'artist_id'     => $artist_id,
            'is_promoter'   => $user->is_promoter(),
            'show_all'      => true
        ));

        // Create update events and messages
        EventApi::createBookingUpdateEvents($old_data, $new_data, $user);

        // @TODO: Deprecated and must be replaced with Events
        BookingApi::createUpdateMessages($old_data, $new_data, $user);

        // Send adjust message
        if ($user->is_promoter()) {
            Mailer::sendBookingAdjustEmailToArtist($artist_id, $gig_id);
        } else {
            Mailer::sendBookingAdjustEmailToPromoter($artist_id, $gig_id);
        }

        // Clean gig caches
        Cache::clean(Cache::GIG_NS);
        Cache::clean(Cache::MESSAGE_NS);

        // Compile result and return
        $result = array(
            'result'    => ApiStatus::SUCCESS,
            'data'      => $user->is_promoter() ?
                PromoterApi::getGigs($user->promoter()->id) : ArtistApi::getBookings($user->artist()->id)
        );
        $this->renderJSON($result);
    }

    /**
     * Return booking details
     */
    public function actionUpdateStatus()
    {
        // Get params
        $request = Yii::app()->request;
        $gig_id = (int)$request->getPost('gig_id');
        $artist_id = (int)$request->getPost('artist_id');
        $status = (int)$request->getPost('status');

        // Check login state
        if ($user = User::getLogged()) {
            if (BookingApi::updateStatus($gig_id, $artist_id, $status, $user->is_promoter())) {

                if ($status == ArtistGig::STATUS_ACCEPTED) {
                    Mailer::sendBookingAcceptEmailToPromoter($artist_id, $gig_id);
                    MessageApi::addAcceptMessageToPromoter($gig_id, $artist_id, $user);
                }

                if ($status == ArtistGig::STATUS_CONFIRMED) {
                    Mailer::sendBookingConfirmEmailToArtist($artist_id, $gig_id);
                    MessageApi::addConfirmMessageToArtist($gig_id, $artist_id, $user);
                }

                if ($status == ArtistGig::STATUS_REJECTED) {
                    if (!$user->is_promoter()) {
                        Mailer::sendBookingRejectEmailToPromoter($artist_id, $gig_id);
                    } else {
                        Mailer::sendBookingRejectEmailToArtist($artist_id, $gig_id);
                    }
                    MessageApi::addRejectMessage($gig_id, $artist_id, $user);
                }

                // Clean gig caches
                Cache::clean(Cache::GIG_NS);
                Cache::clean(Cache::MESSAGE_NS);

                // Return data
                $result = array(
                    'result'    => ApiStatus::SUCCESS,
                    'data'      => $user->is_promoter() ?
                        PromoterApi::getGigs($user->promoter()->id) : ArtistApi::getBookings($user->artist()->id)
                );
            } else {
                $result = array(
                    'result'    => ApiStatus::NO_RECORDS
                );
            }
        } else {
            $result = array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            );
        }

        $this->renderJSON($result);
    }
}