<?php

class PromoterController extends Controller
{
    public function actionList()
    {
        // Get logged in promoter
        $promoter = Promoter::getLogged();
        $promoter_id = $promoter ? $promoter->id : 0;

        // Get promoters
        $promoters = PromoterApi::getList($promoter_id);

        // Validate user input and redirect to the previous page if valid
        if ($promoters) {
            $result = array(
                'result' => ApiStatus::SUCCESS,
                'data'   => $promoters
            );
        } else {
            $result = array(
                'result'  => ApiStatus::ERROR,
                'message' => 'Could not find any records, please check filter.'
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

        // Get artist
        $promoter = PromoterApi::get($id, $alias);
        if ($promoter) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $promoter
            );
        } else {
            $result = array(
                'result'    => ApiStatus::NOT_FOUND,
                'message'   => 'Could not find promoter with such id'
            );
        }

        $this->renderJSON($result);
    }

    public function actionProfile()
    {
        if ($promoter = Promoter::getLogged()) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $promoter->getNormalizedData()
            );
        } else {
            $result = array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            );
        }

        $this->renderJSON($result);
    }

    // @TODO: Decrease Cyclomatic complexity
    // @TODO: Split method for submethods, decrease the number of lines
    public function actionUpdate()
    {
        // Get request
        $request = Yii::app()->request;

        // Check if artist ryed to create promoter profile
        if (!$promoter = Promoter::getLogged()) {
            $result = array(
                'result' => ApiStatus::ERROR,
                'message' => 'You don\'t have permissions to do this.'
            );
        } else {
            $transaction = $promoter->dbConnection->beginTransaction();
            try {
                // Check passwords
                $old_password = $request->getPost('old_password');
                $new_password = $request->getPost('new_password');
                $retype_password = $request->getPost('retype_password');

                if ($old_password && $new_password && $retype_password) {
                    if ($promoter->user->validatePassword($old_password)) {
                        if ($new_password == $retype_password) {
                            $promoter->user->password = CPasswordHelper::hashPassword($new_password);
                            $promoter->user->save();
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
                    $promoter->name = strip_tags($name);
                }

                $description = $request->getPost('description');
                if (!empty($description)) {
                    $promoter->description = strip_tags($description, implode('', Model::$allowed_tags));;
                }

                // Update location
                $latitude = $request->getPost('latitude');
                if (!empty($latitude)) {
                    $promoter->latitude = (float)$latitude;
                }

                $longitude = $request->getPost('longitude');
                if (!empty($longitude)) {
                    $promoter->longitude = (float)$longitude;
                }

                $radius = $request->getPost('radius');
                if (!empty($radius)) {
                    $promoter->radius = (int)$radius;
                }

                $address = $request->getPost('address');
                if (!empty($address)) {
                    $promoter->address = $address;
                }

                $facebook = $request->getPost('facebook');
                if (!empty($facebook)) {
                    $promoter->facebook = $facebook;
                }

                $twitter = $request->getPost('twitter');
                if (!empty($twitter)) {
                    $promoter->twitter = $twitter;
                }

                $homepage = $request->getPost('homepage');
                if (!empty($homepage)) {
                    $promoter->homepage = $homepage;
                }

                // Save and check uploaded file
                if ($promoter->save()) {
                    $file_id = $request->getPost('file_id');
                    if (!empty($file_id)) {
                        // Move uploaded file
                        if ($file = File::model()->find('id = ' . $file_id)) {
                            if (strstr($file->path, 'temp')) {
                                $new_path = str_replace('temp', 'promoter', $file->path);
                                if (rename($file->path, $new_path)) {
                                    $file->path = $new_path;
                                    if (!$file->save()) {
                                        ApiException::raise(ApiException::CAN_NOT_SAVE_FILE);
                                    } else {
                                        $file->generateThumbnails();
                                    }
                                } else {
                                    ApiException::raise(ApiException::CAN_NOT_MOVE_FILE);
                                }
                            }

                            // Save file record
                            $promoterFile = new PromoterFile();
                            $promoterFile->file_id      = $file_id;
                            $promoterFile->promoter_id  = $promoter->id;
                            $promoterFile->save();
                        } else {
                            ApiException::raise(ApiException::CAN_NOT_UPLOAD_FILE);
                        }
                    }
                    $transaction->commit();

                    // Clean messages caches
                    Cache::clean(Cache::PROMOTER_NS);

                    $result = array(
                        'result'    => ApiStatus::SUCCESS,
                        'data'      => $promoter->user->getNormalizedData(true, true),
                        'message'   => 'Your profile has been updated'
                    );
                } else {
                    $result = array(
                        'result'    => ApiStatus::INVALID,
                        'errors'    => $promoter->getErrors(),
                        'message'   => 'Please fix errors bellow and try again'
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
     * Return dashboard data for logged in promoter
     */
    public function actionBookings()
    {
        if ($promoter = Promoter::getLogged()) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => PromoterApi::getGigs($promoter->id)
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
     * Send reset password link
     * @param $link
     * @param $email
     * @param $name
     * @return bool $status
     */
    public function sendResetPasswordEmail($link, $email, $name)
    {
        $sender = new Mailer;

        $sender->from = Yii::app()->params['fromEmail'];
        $sender->fromName = Yii::app()->params['fromName'];

        $sender->to = $email;
        $sender->toName = $name;
        $sender->subject = 'Reset password at Starway';

        $this->layout = 'email';
        $sender->message = $this->render('/email/reset-password', array('link' => $link), true);

        return $sender->send();
    }

    /**
     * Return bookings list for logged in promoter
     */
    public function actionBookingDetails()
    {
        $options = array();
        $request = Yii::app()->request;

        // Check search query
        $query = trim($request->getPost('query'));
        if (!empty($query)) {
            $options['query'] = $query;
        }

        // Check empty state
        $options['force_empty'] = (int)$request->getPost('force_empty');

        // Get gigs
        if ($promoter = Promoter::getLogged()) {
            $data = $promoter->getBookingList($options);
            if (count($data)) {
                $result = array(
                    'result'    => ApiStatus::SUCCESS,
                    'data'      => $data
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

    /**
     * Return bookings list for logged in promoter
     */
    public function actionEvents()
    {
        // Get request
        $request = Yii::app()->request;
        $offset = $request->getPost('offset', 0);

        // Get gigs
        if ($promoter = Promoter::getLogged()) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => PromoterApi::getEvents($promoter->id, $offset)
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
     * Return dashboard data for logged in promoter
     */
    public function actionTrackings()
    {
        if ($promoter = Promoter::getLogged()) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => array(
                    'artists' => PromoterApi::getFollowedArtists($promoter->id),
                    'promoters' => PromoterApi::getFollowedPromoters($promoter->id),
                )
            );
        } else {
            $result = array(
                'result'    => ApiStatus::REQ_LOGIN,
                'message'   => 'Please login first'
            );
        }

        $this->renderJSON($result);
    }
}
