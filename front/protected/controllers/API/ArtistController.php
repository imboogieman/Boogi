<?php

// @TODO: Decrease Overall complexity

class ArtistController extends Controller
{
    public function actionList()
    {
        // Get request
        $request = Yii::app()->request;
        $limit = $request->getPost('limit');
        $offset = $request->getPost('offset');
        $query = $request->getPost('query');

        $l_m_count = $request->getPost('load_more_count');

        if ($l_m_count > 3 && !Yii::app()->user->getId()) {
            $result = array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            );
        } else {
            // Get artists
            $artists = ArtistApi::getList( array( 'limit' => $limit, 'offset' => $offset, 'query' => $query ) );

            // Validate user input and redirect to the previous page if valid
            if ( $artists ) {
                $result = array(
                    'result' => ApiStatus::SUCCESS,
                    'data'   => $artists
                );
            } else {
                $result = array(
                    'result'  => ApiStatus::NO_RECORDS,
                    'message' => 'Could not find any records, please check filter'
                );
            }
        }

        $this->renderJSON($result);
    }

    /**
     * Getting gig by id
     */
    public function actionGetgig() {

        // Get request
        $request = Yii::app()->request;
        $gig_id = $request->getPost('gig_id');
        $gig = Gig::getOrCreate($gig_id);
        if (isset($gig->date)) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => array(
                    'id' => $gig_id,
                    'date' => $gig->getDate('Y-m-d'),
                    'venue' => array(
                        'latitude' => $gig->venue->latitude,
                        'longitude' => $gig->venue->longitude
                    )
                )
            );
        } else {
            $result = array(
                'result'    => ApiStatus::NO_RECORDS,
                'message'   => 'Could not find any records'
            );
        }

        $this->renderJSON($result);
    }

    public function actionGet()
    {
        // Get request
        $request = Yii::app()->request;
        $id = $request->getPost('id');
        $alias = $request->getPost('alias');
        $artistCount = $request->getPost('artist_count');

        if ($artistCount > 4 && !Yii::app()->user->getId()) {
            $result = array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            );
        } else {
            // Get artist
            $artist = ArtistApi::get( $id, $alias );
            if ( $artist ) {
                $result = array(
                    'result' => ApiStatus::SUCCESS,
                    'data'   => $artist
                );
            } else {
                $result = array(
                    'result'  => ApiStatus::NOT_FOUND,
                    'message' => 'Could not find artist with such id'
                );
            }
        }

        $this->renderJSON($result);
//        $this->renderJSON(array('work'=>$id));
    }

    // @TODO: Decrease Cyclomatic and NPath complexity
    // @TODO: Split method for submethods, decrease the number of lines
    public function actionBook()
    {
        // Get request
        $is_new_user = false;
        $request = Yii::app()->request;

        // Check if user logged
        if (!$user_id = Yii::app()->user->getId()) {
            $user_id = Promoter::getOrCreateTempAccount(Yii::app()->request->cookies['account']);
            if (!$user_id) {
                $this->renderJSON(array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => 'Cant create temporary account, please use regular registration'
                ));
                return;
            } else {
                $is_new_user = true;
                $account = md5(Yii::app()->params['baseUrl'] . $user_id);
                Yii::app()->request->cookies['account'] = new CHttpCookie('account', $account);
            }
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
            if (!empty($venue_data) && !empty($venue_data['latitude']) && !empty($venue_data['longitude'])) {
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

                $venue->latitude = $venue_data['latitude'];
                $venue->longitude = $venue_data['longitude'];

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

                    if (!$venue->latitude || !$venue->longitude) {
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

        // Create new gig or link to existing
        $gig_id = $request->getPost('gig_id');
        $gig = Gig::getOrCreate($gig_id);

        $gig->name = $request->getPost('name');
        $gig->description = $request->getPost('description');
        $gig->user_id = $user_id;
        $gig->venue_id = $venue_id;
        $gig->address = $address;

        $gig->datetime_from = Model::parseDateTime($request->getPost('gig_date_from'), $request->getPost('gig_time_from'));
        $gig->datetime_to = Model::parseDateTime($request->getPost('gig_date_to'), $request->getPost('gig_time_to'));
        $gig->timezone = $request->getPost('gig_timezone');

        $gig->price = (int)$request->getPost('gig_price');
        $gig->currency = (int)$request->getPost('gig_currency');

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

        // Link artist to gig
        $artistGig = new ArtistGig;
        $artistGig->gig_id = $gig->id;
        $artistGig->artist_id = $request->getPost('artist_id');

        $artistGig->status = $is_new_user ? ArtistGig::STATUS_HIDDEN : ArtistGig::STATUS_OPEN;

        $artistGig->datetime_from = Model::parseDateTime($request->getPost('book_date_from'), $request->getPost('book_time_from'));
        $artistGig->datetime_to = Model::parseDateTime($request->getPost('book_date_to'), $request->getPost('book_time_to'));
        $artistGig->timezone = $request->getPost('book_timezone');

        $artistGig->price = (int)$request->getPost('book_price');
        $artistGig->currency = $request->getPost('book_currency');
        $artistGig->revenue_share = (int)$request->getPost('revenue_share');

        $artistGig->accommodation = (int)$request->getPost('accommodation');
        $artistGig->transfer = (int)$request->getPost('transfer');
        $artistGig->last_changed = User::ROLE_PROMOTER;

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

        // Add message if exists
        if ($request->getPost('message')) {
            $message = new Message;
            $message->type = Message::TYPE_PROMOTER_MESSAGE;
            $message->artist_id = $request->getPost('artist_id');
            $message->gig_id = $gig->id;
            $message->message = $request->getPost('message');

            if (!$message->save()) {
                $transaction->rollback();
                $this->renderJSON(array(
                    'result'    => ApiStatus::INVALID,
                    'errors'    => $message->getErrors(),
                    'message'   => 'Please fix errors bellow and try again'
                ));
                return;
            }
        }

        // Create event
        if (!$is_new_user && $promoter = Promoter::getLogged()) {
            $promoter->getOrCreateEvent(Event::BOOKING_CREATE, $gig, $artistGig->artist);
            $promoter->createCascadeEvents(Event::BOOKING_CREATE, $artistGig->artist);

            // Send booking confirmation emails
            Mailer::sendBookingEmailsByBookingId($promoter, $artistGig->id);
        }

        // Save all data in transaction
        $message = $is_new_user ?
            "Thank you.<br /> To complete your request, please, register.<br /> After registration, you can see the booking status in your Dashboard." :
            "Thank you.<br /> Your request just has been sent. Please, await for reply.<br /> You can see the booking status in your Dashboard.";

        $transaction->commit();

        // Remember for future notification email
        if ($is_new_user) {
            $bookings = explode(',', Yii::app()->request->cookies['bookings']);
            if (!empty($bookings)) {
                $bookings[] = $artistGig->id;
            } else {
                $bookings = array($artistGig->id);
            }
            Yii::app()->request->cookies['bookings'] = new CHttpCookie('bookings', implode(',', $bookings));
        }

        // Clean all artist related caches
        Cache::clean(Cache::GIG_NS);
        Cache::clean(Cache::MESSAGE_NS);

        $this->renderJSON(array(
            'result'        => ApiStatus::SUCCESS,
            'message'       => $message,
            'artist_id'     => $request->getPost('artist_id'),
            'is_new_user'   => $is_new_user ? 1 : 0
        ));
    }

    // @TODO: Decrease Cyclomatic and NPath complexity
    // @TODO: Split method for submethods, decrease the number of lines
    public function actionUpdate()
    {
        // Get request
        $request = Yii::app()->request;

        // Check if artist ryed to create promoter profile
        if (!$artist = Artist::getLogged()) {
            $result = array(
                'result' => ApiStatus::ERROR,
                'message' => 'You don\'t have permissions to do this.'
            );
        } else {
            $transaction = $artist->dbConnection->beginTransaction();
            try {
                // Check passwords
                $old_password = $request->getPost('old_password');
                $new_password = $request->getPost('new_password');
                $retype_password = $request->getPost('retype_password');

                if ($old_password && $new_password && $retype_password) {
                    if ($artist->user->validatePassword($old_password)) {
                        if ($new_password == $retype_password) {
                            $artist->user->password = CPasswordHelper::hashPassword($new_password);
                            $artist->user->save();
                        } else {
                            ApiException::raise(ApiException::PASSWORDS_DOES_NOT_MATCH);
                        }
                    } else {
                        ApiException::raise(ApiException::WRONG_PASSWORD);
                    }
                }

                // Update general info
                $name = $request->getPost('name');
                if (!empty($name)) {
                    $artist->name = strip_tags($name);
                }

                $description = $request->getPost('description');
                if (!empty($description)) {
                    $artist->description = strip_tags($description, implode('', Model::$allowed_tags));
                }

                // Location info
                $latitude = $request->getPost('latitude');
                if (!empty($latitude)) {
                    $artist->latitude = (float)$latitude;
                }

                $longitude = $request->getPost('longitude');
                if (!empty($longitude)) {
                    $artist->longitude = (float)$longitude;
                }

                // Social info
                $fb_id = $request->getPost('fb_id');
                if (!empty($fb_id)) {
                    $artist->fb_id = (int)$fb_id;
                }

                $data_provider = $request->getPost('data_provider');
                if (!empty($data_provider)) {
                    $artist->data_provider = $data_provider;
                }

                // Save and check uploaded file
                if ($artist->save()) {
                    $file_id = $request->getPost('file_id');
                    if (!empty($file_id)) {
                        // Move uploaded file
                        if ($file = File::model()->find('id = ' . $file_id)) {
                            if (strstr('temp', $file->path)) {
                                $new_path = str_replace('temp', 'artist', $file->path);
                                if (rename($file->path, $new_path)) {
                                    $file->path = $new_path;
                                    if (!$file->save()) {
                                        ApiException::raise(ApiException::CAN_NOT_SAVE_FILE);
                                    }
                                } else {
                                    ApiException::raise(ApiException::CAN_NOT_MOVE_FILE);
                                }
                            }

                            // Save file record
                            $artistFile = new ArtistFile();
                            $artistFile->file_id    = $file_id;
                            $artistFile->artist_id  = $artist->id;
                            $artistFile->save();
                        } else {
                            ApiException::raise(ApiException::CAN_NOT_UPLOAD_FILE);
                        }
                    }
                    $transaction->commit();

                    // Clean artist caches
                    Cache::clean(Cache::ARTIST_NS);

                    $result = array(
                        'result'    => ApiStatus::SUCCESS,
                        'data'      => $artist->user->getNormalizedData(true, true),
                        'message'   => 'Your profile has been updated'
                    );
                } else {
                    $result = array(
                        'result'    => ApiStatus::INVALID,
                        'errors'    => $artist->getErrors(),
                        'message'   => 'Please fix errors bellow and try again',
                    );
                }
            } catch (ApiException $e) {
                if ($transaction) {
                    $transaction->rollback();
                }

                $result = array(
                    'result'    => ApiStatus::INVALID,
                    'errors'    => array($e->getApiError()),
                    'message'   => 'Please fix errors bellow and try again'
                );
            } catch (Exception $e) {
                if ($transaction) {
                    $transaction->rollback();
                }

                $result = array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => $e->getMessage()
                );
            }
        }

        $this->renderJSON($result);
    }

    /**
     * Return dashboard data for logged in artist
     */
    public function actionBookings()
    {
        if ($artist = Artist::getLogged()) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => ArtistApi::getBookings($artist->id)
            );
        } else {
            $result = array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Search artist on Facebook
     */
    public function actionSearchOnFacebook()
    {
        // Get query
        $query = Yii::app()->request->getPost('query');
        $mild = Yii::app()->request->getPost('mild') ? true : false;

        // Get query
        if ($artists = ArtistApi::searchOnFacebook($query, $mild)) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $artists
            );
        } else {
            $result = array(
                'result'    => ApiStatus::NO_RECORDS,
                'message'   => 'Can\'t find any artist'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Import artist from Facebook
     */
    public function actionImportFromFacebook()
    {
        // Get query
        $fb_id = Yii::app()->request->getPost('fb_id');

        // Get query
        if ($artist = ArtistApi::importFromFacebook($fb_id)) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $artist
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Can\'t import this artist, please try later'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Import artist from Facebook
     */
    public function actionImportGigs()
    {
        // Get query
        $fb_id = Yii::app()->request->getPost('fb_id');

        // Get query
        if ($gigs = ArtistApi::importGigs($fb_id)) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => count($gigs)
            );
        } else {
            $result = array(
                'result'    => ApiStatus::NO_RECORDS,
                'message'   => 'Can\'t find any gigs for this artist'
            );
        }

        $this->renderJSON($result);
    }
}