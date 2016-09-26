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
