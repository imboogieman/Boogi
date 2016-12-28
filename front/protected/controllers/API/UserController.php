<?php


class UserController extends Controller
{
    // @TODO: Replace $_POST global variable
    public function actionLogin()
    {
        // Fix post email
        $_POST['email'] = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '';

        // Create user
        $user = new User;
        $user->attributes = $_POST;

        // Validate user input and redirect to the previous page if valid
        if ($user->login()) {
            // Check promoter account
            if ($user->role == User::ROLE_PROMOTER) {
                if (isset(Yii::app()->request->cookies['account']) && !empty(Yii::app()->request->cookies['account'])) {
                    $account = Yii::app()->request->cookies['account'];
                    if ($account = Promoter::getByAccount($account)) {
                        PromoterApi::updateByAccount($account);
                    }
                }
            }

            // Send response
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $user->getEntity()->getNormalizedData(true, true)
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Could not find user with given credentials'
            );
        }

        $this->renderJSON($result);
    }

    public function actionSwitch()
    {
        if ($user = UserApi::switchRole()) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'message'   => 'Your account was succesfully switched',
                'data'      => $user
            );
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Can\'t switch your account. Please contact to support'
            );
        }
        $this->renderJSON($result);
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $result = array('result' => ApiStatus::SUCCESS);

        $this->renderJSON($result);
    }

    /**
     * Register new user
     * @TODO: Decrease Cyclomatic complexity
     * @TODO: Split method for submethods, decrease the number of lines
     */
    public function actionRegister()
    {
        $artist = $promoter = $already_registered = null;
        $request = Yii::app()->request;

        // Get base params
        $role = $request->getPost('role');
        $name = $request->getPost('name');
        $email = trim(strtolower($request->getPost('email')));
        $password = $request->getPost('password');
        $account = isset($request->cookies['account']) ? $request->cookies['account'] : null;

        // Check already registered user
        $user = User::model()->find('email = :email', array(':email' => $email));
        if ($user) {
            if ($user->validatePassword($password) && $user->login()) {
                if ($role == User::ROLE_PROMOTER) {
                    $already_registered = true;
                    $promoter = $user->promoter();
                } else {
                    $artist = $user->artist();
                }
            } else {
                $this->renderJSON(array(
                    'result'    => ApiStatus::INVALID,
                    'errors'    => array(
                        array('field' => 'register-password', 'message' => 'Password does not match')
                    ),
                    'message'   => 'This email already registered'
                ));
                return;
            }
        }

        // Check user role and create/update appropriate profile
        try {
            if ($role == User::ROLE_PROMOTER) {
                if (!$already_registered) {
                    if ($account) {
                        $promoter = Promoter::getByAccount($account);
                    }
                    if (!$promoter) {
                        $promoter = new Promoter;
                    }
                    $promoter->attributes = array(
                        'name'      => $request->getPost('name'),
                        'latitude'  => $request->getPost('latitude'),
                        'longitude' => $request->getPost('longitude'),
                        'radius'    => $request->getPost('radius')
                    );
                    $promoter->bindRelatedParams(array(
                        'email'     => $email,
                        'password'  => $password,
                        'role'      => $request->getPost('role', 1),
                        'create_date' => date('Y-m-d')
                    ));
                }

                if ($promoter->save()) {
                    $promoter->user->login();

                    if ($account = Promoter::getByAccount($account)) {
                        PromoterApi::updateByAccount($account);
                    } else {
                        Mailer::sendRegisterEmail(array('email' => $email, 'name' => $name));
                    }

                    $result = array(
                        'result'    => ApiStatus::SUCCESS,
                        'data'      => $promoter->user->getNormalizedData(),
                        'message'   => $account ?
                            'Your booking request has just been send.<br />
                             Booked artist will be likely to respond positively, if you fill up your profile
                             with true and up-to-date information.<br />
                             Please, take time to fill up your profile.' : ''
                    );
                } else {
                    $result = array(
                        'result'    => ApiStatus::INVALID,
                        'errors'    => $promoter->getErrors()
                    );
                }
            } else {
                $artist = $artist ? $artist : new Artist;

                $artist->attributes = array(
                    'name'      => $request->getPost('name'),
                    'latitude'  => $request->getPost('latitude'),
                    'longitude' => $request->getPost('longitude')
                );
                $artist->bindRelatedParams(array(
                    'email'     => $email,
                    'password'  => $password,
                    'role'      => $request->getPost('role'),
                ));

                if ($artist->save()) {
                    $artist->user->login();
                    $result = array(
                        'result'    => ApiStatus::SUCCESS,
                        'data'      => $artist->user->getNormalizedData()
                    );
                } else {
                    $result = array(
                        'result'    => ApiStatus::INVALID,
                        'errors'    => $artist->getErrors()
                    );
                }
            }
        } catch (CException $e) {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => $e->getMessage()
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Register new user
     * @TODO: Decrease Cyclomatic complexity
     * @TODO: Split method for submethods, decrease the number of lines
     */
    public function actionSubmitregister() {
        $artist  = $promoter = $already_registered = null;
        $request = Yii::app()->request;

        // Get base params
        $role = User::ROLE_PROMOTER;
        $fbId = $request->getPost( 'fbId' );
        $name = $request->getPost( 'name' );
        $page = $request->getPost( 'page' );
        $email = trim(strtolower($request->getPost( 'email' )));
        $pass = $request->getPost( 'pass' );
        $genres = $request->getPost( 'genres' );
        $experience = $request->getPost( 'experience' );
        $address = $request->getPost( 'address' );
        $lat = $request->getPost( 'lat' );
        $lng = $request->getPost( 'lng' );
        $radius = $request->getPost( 'radius' );
        $fArtists = $request->getPost( 'fArtists' );
        $to_track_arr = json_decode($request->getPost( 'to_track_arr' ));
        $cName = $request->getPost( 'cName' );
//        $category = $request->getPost( 'category' );
        $cAddress = $request->getPost( 'cAddress' );
        $foundingDate = $request->getPost( 'foundingDate' );
        $phone = $request->getPost( 'phone' );
        $website = $request->getPost( 'website' );
        $description = $request->getPost( 'description' );

        $account = null;//isset($request->cookies['account']) ? $request->cookies['account'] : null;

        // Check already registered user
        $user = User::model()->with('promoters')->find('email = :email or fb_id = :fb_id',
            array(':email' => $email, ':fb_id' => $fbId));

        // Check user role and create/update appropriate profile
        try {
            if ($role == User::ROLE_PROMOTER) {
                if ($user) {
                    $promoter = $user->promoter();
                } else {
                    $promoter = new Promoter;
                }

                $promoter->attributes = array(
                    'name'      => $cName,
                    'latitude'  => $lat !== '' ? $lat : Model::getDefaultLatitude(),
                    'longitude' => $lng !== '' ? $lng : Model::getDefaultLongitude(),
                    'radius'    => $radius,
                    'address'   => $address,
                    'fb_id'     => $fbId,
                    'facebook'  => 'http://facebook.com/profile.php?id='.$fbId,
                    'facebook_name' => $cName,
                    'homepage'  => $website,
                    'description' => $description,
                    'page'      => $page,
                    'genres'   => $genres,
                    'experience' => $experience,
                    'f_artists' => $fArtists
                );
                $promoter->bindRelatedParams(array(
                    'email'     => $email,
                    'password'  => $pass,
                    'role'      => $role,
                    'create_date' => date('Y-m-d'),
                    'c_name'      => $name,
//                    'category'  => $category,
                    'c_address'   => $cAddress,
                    'founding_date' => date('Y-m-d', strtotime($foundingDate)),
                    'phone' => $phone,
                    'website' => $website,
                    'description' => $description
                ));

                if ($promoter->save()) {
                    $promoter->user->login();

                    $this->_artistsToTrack($promoter, $to_track_arr);
                    if ($account = Promoter::getByAccount($account)) {
                        PromoterApi::updateByAccount($account);
                    } else {
                        Mailer::sendRegisterEmail(array('email' => $email, 'name' => $name));
                    }

                    $result = array(
                        'result'    => ApiStatus::SUCCESS,
                        'data'      => $promoter->user->getNormalizedData(true, true),
                        'message'   => ''
//                        'message'   => $account ?
//                            'Your booking request has just been send.<br />
//                             Booked artist will be likely to respond positively, if you fill up your profile
//                             with true and up-to-date information.<br />
//                             Please, take time to fill up your profile.' : ''
                    );
                } else {
                    $result = array(
                        'result'    => ApiStatus::INVALID,
                        'errors'    => $promoter->getErrors()
                    );
                }
            } else {
                $artist = $artist ? $artist : new Artist;

                $artist->attributes = array(
                    'name'      => $request->getPost('name'),
                    'latitude'  => $request->getPost('latitude'),
                    'longitude' => $request->getPost('longitude')
                );
                $artist->bindRelatedParams(array(
                    'email'     => $email,
                    'password'  => $pass,
                    'role'      => $request->getPost('role'),
                ));

                if ($artist->save()) {
                    $artist->user->login();
                    $result = array(
                        'result'    => ApiStatus::SUCCESS,
                        'data'      => $artist->user->getNormalizedData()
                    );
                } else {
                    $result = array(
                        'result'    => ApiStatus::INVALID,
                        'errors'    => $artist->getErrors()
                    );
                }
            }
        } catch (CException $e) {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => $e->getMessage()
            );
        }

        $this->renderJSON($result);
    }

    protected function _artistsToTrack($promoter, $to_track_arr) {
        $isNewRelation = false;

        foreach($to_track_arr as $item_to_track) {
            // Check follow type
            switch ( $item_to_track->follow_type ) {
                case 'promoter':
                    $event_type = Event::FOLLOW_PROMOTER;
                    $item       = Promoter::model()->findByPk( $item_to_track->follow_id );
                    if ( ! $item ) {
                        break;
                    }

                    $relation = PromoterPromoter::model()->find(
                        'promoter_id = :promoter_id AND follow_id = :follow_id',
                        array(
                            ':promoter_id' => $promoter->id,
                            ':follow_id'   => $item->id,
                        )
                    );

                    if ( ! $relation ) {
                        $isNewRelation         = true;
                        $relation              = new PromoterPromoter;
                        $relation->promoter_id = $promoter->id;
                        $relation->follow_id   = $item->id;
                    }
                    break;
                default:
                    $event_type = Event::FOLLOW_ARTIST;
                    $item       = Artist::model()->findByPk( $item_to_track->follow_id );
                    if ( ! $item ) {
                        break;
                    }

                    $relation = ArtistPromoter::model()->find(
                        'promoter_id = :promoter_id AND artist_id = :artist_id',
                        array(
                            ':promoter_id' => $promoter->id,
                            ':artist_id'   => $item->id,
                        )
                    );

                    if ( ! $relation ) {
                        $isNewRelation         = true;
                        $relation              = new ArtistPromoter;
                        $relation->promoter_id = $promoter->id;
                        $relation->artist_id   = $item->id;
                    }
                    break;
            }

            if ( $item ) {
                if ( $isNewRelation ) {
                    if ( $relation->save() ) {
                        // Create event
                        $promoter->getOrCreateEvent( $event_type, $item );
                        Yii::app()->cache->delete( 'dashboard-' . $promoter->id );

                        $result['to_track'][$item_to_track->follow_id]['result'] = ApiStatus::SUCCESS;
                    } else {
                        $result['to_track'][$item_to_track->follow_id] = array(
                            'result' => ApiStatus::INVALID,
                            'errors' => $relation->getErrors()
                        );
                    }
                } else {
                    $result['to_track'][$item_to_track->follow_id] = array(
                        'result'  => ApiStatus::ERROR,
                        'message' => 'You already following this artist'
                    );
                }
            } else {
                $result['to_track'][$item_to_track->follow_id] = array(
                    'result'  => ApiStatus::ERROR,
                    'message' => 'Cant find following item'
                );
            }
        }

        return $result;
    }

    /**
     * Set facebook access token to a session
     * and redirect to register form
     */
    public function actionFbauth()
    {
        $session = new CHttpSession;
        $session->open();
        $domain = Yii::app()->params['baseUrl'];

        $request = Yii::app()->request;
        $code = $request->getQuery('code', null);
        $profile = null;

        if ($code) {
            $data = Facebook::getAccessMarker($code);
            $session["fbtoken"] = $data['access_token'];
            $profile = Facebook::getProfile( $session['fbtoken'] );
        }

        if ($profile) {
            $user = User::model()->with( 'promoters' )->find( 'email = :email or fb_id = :fb_id',
                array( ':email' => $profile['email'], ':fb_id' => $profile['id'] ) );
            if ( $user && $user->login()) {
                    header( 'location: ' . $domain . 'promoter/profile' );
            } else {
                header('location: '. $domain. 'user/fb-register');
            }
        } else {
            header('location: '. $domain);
        }
    }


    /**
     * Get details facebook account
     */
    public function actionFbregister()
    {
        $session=new CHttpSession;
        $session->open();
        if ($session['fbtoken']) {
            $result = array(
                'result'  => ApiStatus::SUCCESS,
                'message' => 'Your account was succesfully switched',
                'pages'   => Facebook::getPages( $session['fbtoken'] ),
                'profile' => Facebook::getProfile( $session['fbtoken'] ),
            );
        } else {
            $result = array(
                'result'    => ApiStatus::INVALID,
                'errors'    => 'Not registered by facebook'
            );
        }
        $this->renderJSON($result);
    }

    /**
     *
     */
    public function actionInstagram()
    {
        $request = Yii::app()->request;
        $code = $request->getQuery('code', null);
        $profile = null;

        if ($code) {
            var_dump($code);die;
        }

        $session=new CHttpSession;
        $session->open();
        if ($session['insttoken']) {
            $result = array(
                'result'  => ApiStatus::SUCCESS,
                'message' => 'Your account was succesfully switched',
            );
        } else {
            $result = array(
                'result'    => ApiStatus::INVALID,
                'errors'    => 'Not registered by instagram'
            );
        }
//        $this->renderJSON($result);
    }

    /**
     * Get calling code
     */
    public function actionGetcallingcode() {
        $c_code = Callingcodes::getCode();
        if ($c_code) {
            $result = array(
                'result'    => ApiStatus::SUCCESS,
                'data'      => $c_code
            );
        } else {
            $result = array(
                'result'    => ApiStatus::NO_RECORDS,
                'message'   => 'Could not find counry code'
            );
        }

        $this->renderJSON($result);
    }

    public function actionRestore()
    {
        // Get request
        $request = Yii::app()->request;

        // Create user
        $email = trim(strtolower($request->getPost('email')));
        if (!empty($email)) {
            $user = User::model()->find('email = :email', array(':email' => $email));

            // Generate reset link and try to send it
            $link = $user ? $user->generateResetPasswordLink() : false;
            $name = $user->promoters ? $user->promoters[0]->name :
                $user->artists ? $user->artists[0]->name : null;

            if ($link) {
                if (Mailer::sendResetPasswordEmail(array('name' => $name, 'email' => $email, 'link' => $link))) {
                    $result = array(
                        'result'    => ApiStatus::SUCCESS,
                        'message'   => 'Please check your email.'
                    );
                } else {
                    $result = array(
                        'result'    => ApiStatus::ERROR,
                        'message'   => 'Could not send email, please try later'
                    );
                }
            } else {
                $result = array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => 'Could not find user with given credentials'
                );
            }
        } else {
            $result = array(
                'result'    => ApiStatus::INVALID,
                'errors'    => array('email' => 'Email could not be empty')
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Search artists
     */
    function actionSearchartist() {
        // Get request
        $request = Yii::app()->request;

        $query = $request->getQuery('q');
        if ($query) {
            $result = ArtistApi::searchByQuery($query);
            if ($result) {
                $result = array(
                    'result' => ApiStatus::SUCCESS,
                    'data'   => $result
                );
            } else {
                $result = array(
                    'result' => ApiStatus::SUCCESS,
                    'data'   => array(array(
                        'link'  => '',
                        'image' => '',
                        'name'  => 'Artist not finded',
                        'description' => ''
                    ))
                );
            }
        } else {
            $result = array();
        }

        $this->renderJSON($result);
    }

    /**
     * Get recommended artists
     */
    function actionGetrecommendedart() {
        // Get request
        $request = Yii::app()->request;

        $from = $request->getPost('from');
        $count = $request->getPost('to');
        $result = ArtistApi::getRecomendedArtist($from, $count);
        if ($result) {
            $result = array(
                'result' => ApiStatus::SUCCESS,
                'data'   => $result
            );
        } else {
            $result = array(
                'result'    => ApiStatus::INVALID,
                'errors'    => array('er' => 'error')
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Check restore password hash
     */
    public function actionCheckhash()
    {
        // Get request
        $request = Yii::app()->request;

        // Get hash and check it
        $hash = $request->getPost('hash');
        if (!empty($hash)) {
            $user = User::model()->find('reset_hash = :reset_hash', array(':reset_hash' => $hash));
            if ($user) {
                $result = array(
                    'result'    => ApiStatus::SUCCESS
                );
            } else {
               $result = array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => 'Your reset link expired, please try again'
                );
            }
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Invalid restore link, please try again'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Set new user password
     */
    public function actionNewpass()
    {
        // Get request
        $request = Yii::app()->request;

        // Get hash and check it
        $hash = $request->getPost('hash');
        if (!empty($hash)) {
            $user = User::model()->find('reset_hash = :reset_hash', array(':reset_hash' => $hash));
            if ($user) {
                $password = $request->getPost('password');
                $password2 = $request->getPost('password2');

                if ($password == $password2) {
                    if ($user->setNewPass($password)) {
                        $result = array(
                            'result'    => ApiStatus::SUCCESS,
                            'message'   => 'You password has been changed. Now you can login with him'
                        );
                    } else {
                        $result = array(
                            'result'    => ApiStatus::ERROR,
                            'message'   => 'Something went wrong, please try later'
                        );
                    }
                } else {
                    $result = array(
                        'result'    => ApiStatus::ERROR,
                        'message'   => 'Passwords did not match'
                    );
                }
            } else {
                $result = array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => 'Your reset link expired, please try again'
                );
            }
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Invalid restore link, please try again'
            );
        }

        $this->renderJSON($result);
    }

    public function actionUpgrade()
    {
        // Get upgrade plan
        $plan = Yii::app()->request->getPost('plan');

        if ($user_id = Yii::app()->user->getId()) {
            if ($artists = UserApi::upgrade($user_id, $plan)) {
                $result = array(
                    'result'    => ApiStatus::SUCCESS,
                    'message'   => 'Your account plan was succesfully updated',
                    'user'      => User::getLogged()->getNormalizedData(true, true)
                );
            } else {
                $result = array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => 'Can\'t upgrade your plan. Please contact to support'
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
