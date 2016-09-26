<?php

class SiteController extends Controller
{

    public function actionContact()
    {
        // Get request
        $request = Yii::app()->request;

        // Get artists
        $contact = new Contact;

        // Validate user input and redirect to the previous page if valid
        $source = $request->getPost('source', 'contact');
        $name = $request->getPost('name');
        $email = $request->getPost('email');
        $message = $request->getPost('message');

        if (!empty($name) && !empty($email) && !empty($message)) {
            $contact->source = $source;
            $contact->name = $name;
            $contact->email = $email;
            $contact->message = $message;

            if ($contact->save()) {
                $result = array(
                    'result'    => ApiStatus::SUCCESS,
                    'data'      => $contact->id,
                    'message'   => 'You message successfully sent'
                );
            } else {
                $result = array(
                    'result'    => ApiStatus::INVALID,
                    'errors'    => $contact->getErrors()
                );
            }
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Please enter your email, name and message'
            );
        }

        $this->renderJSON($result);
    }

    public function actionUpload()
    {
        $model = new File;
        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $image_name = 'images/storage/temp/' . substr(md5(time()), 0, 10) . '.' . $file->getExtensionName();
            if (!$file->getHasError() && $file->saveAs($image_name)) {
                $model->path = $image_name;
                if ($model->save()) {
                    $result = array(
                        'result'  => ApiStatus::SUCCESS,
                        'file_id' => $model->id,
                        'file_name' => '/' . $image_name
                    );
                } else {
                    $result = array(
                        'result'  => ApiStatus::INVALID,
                        'errors'  => $model->getErrors()
                    );
                }
            } else {
                $result = array(
                    'result'  => ApiStatus::INVALID,
                    'errors' => array('image' => $file->getError())
                );
            }
        } else {
            $result = array(
                'result'  => ApiStatus::ERROR,
                'errors'  => 'Can\'t upload file'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Follow item to current promoter
     * @TODO: Decrease Cyclomatic complexity
     * @TODO: Split method for submethods, decrease the number of lines
     */
    public function actionFollow()
    {
        // Get request
        $request = Yii::app()->request;

        $follow_id = $request->getPost('id');
        $follow_type = $request->getPost('type', 'artist');

        if ($follow_id) {
            $result = array();

            // Check login status
            $promoter = Promoter::getLogged();
            if ($promoter && $promoter->id != $follow_id) {
                $isNewRelation = false;

                // Check follow type
                switch ($follow_type) {
                    case 'promoter':
                        $event_type = Event::FOLLOW_PROMOTER;
                        $item = Promoter::model()->findByPk($follow_id);
                        if (!$item) {
                            break;
                        }

                        $relation = PromoterPromoter::model()->find(
                            'promoter_id = :promoter_id AND follow_id = :follow_id',
                            array(
                                ':promoter_id' => $promoter->id,
                                ':follow_id'   => $item->id,
                            )
                        );

                        if (!$relation) {
                            $isNewRelation = true;
                            $relation = new PromoterPromoter;
                            $relation->promoter_id = $promoter->id;
                            $relation->follow_id = $item->id;
                        }
                        break;
                    default:
                        $event_type = Event::FOLLOW_ARTIST;
                        $item = Artist::model()->findByPk($follow_id);
                        if (!$item) {
                            break;
                        }

                        $relation = ArtistPromoter::model()->find(
                            'promoter_id = :promoter_id AND artist_id = :artist_id',
                            array(
                                ':promoter_id' => $promoter->id,
                                ':artist_id'   => $item->id,
                            )
                        );

                        if (!$relation) {
                            $isNewRelation = true;
                            $relation = new ArtistPromoter;
                            $relation->promoter_id = $promoter->id;
                            $relation->artist_id = $item->id;
                        }
                        break;
                }

                if ($item) {
                    if ($isNewRelation) {
                        if ($relation->save()) {
                            // Create event
                            $promoter->getOrCreateEvent($event_type, $item);
                            Yii::app()->cache->delete('dashboard-' . $promoter->id);

                            $result['result'] = ApiStatus::SUCCESS;
                        } else {
                            $result = array(
                                'result'    => ApiStatus::INVALID,
                                'errors'    => $relation->getErrors()
                            );
                        }
                    } else {
                        $result = array(
                            'result'    => ApiStatus::ERROR,
                            'message'   => 'You already following this artist'
                        );
                    }
                } else {
                    $result = array(
                        'result'    => ApiStatus::ERROR,
                        'message'   => 'Cant find following item'
                    );
                }
            } else if ($promoter) {
                $result = array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => 'You cant track self'
                );
            } else {
                $result = array(
                    'result'    => ApiStatus::REQ_LOGIN,
                    'message'   => 'Please login first'
                );
            }
        } else {
            $result = array(
                'result'    => ApiStatus::ERROR,
                'message'   => 'Follow ID could not be empty'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Unfollow item from current promoter.
     */
    public function actionUnfollow()
    {
        // Get request
        $request = Yii::app()->request;

        $follow_id = $request->getPost('id');
        $follow_type = $request->getPost('type', 'artist');

        if ($follow_id) {
            $result = array();

            // Check login status
            $promoter = Promoter::getLogged();
            if ($promoter) {
                // Check follow type
                switch ($follow_type) {
                    case 'promoter':
                        $event_type = Event::UNFOLLOW_PROMOTER;
                        $item = Promoter::model()->findByPk($follow_id);
                        if (!$item) {
                            break;
                        }

                        $relation = PromoterPromoter::model()->find(
                            'promoter_id = :promoter_id AND follow_id = :follow_id',
                            array(
                                ':promoter_id' => $promoter->id,
                                ':follow_id'   => $item->id,
                            )
                        );
                        break;
                    default:
                        $event_type = Event::UNFOLLOW_ARTIST;
                        $item = Artist::model()->findByPk($follow_id);
                        if (!$item) {
                            break;
                        }

                        $relation = ArtistPromoter::model()->find(
                            'promoter_id = :promoter_id AND artist_id = :artist_id',
                            array(
                                ':promoter_id' => $promoter->id,
                                ':artist_id'   => $item->id,
                            )
                        );
                        break;
                }

                if ($item) {
                    if ($relation) {
                        if ($relation->delete()) {
                            // Create event
                            $promoter->getOrCreateEvent($event_type, $item);
                            Yii::app()->cache->delete('dashboard-' . $promoter->id);

                            $result['result']   = ApiStatus::SUCCESS;
                            $result['name']     = $item->name;
                            $result['link']     = $item->getLink();
                        } else {
                            $result = array(
                                'result' => ApiStatus::INVALID,
                                'errors' => $relation->getErrors()
                            );
                        }
                    } else {
                        $result = array(
                            'result' => ApiStatus::ERROR,
                            'error' => 'You are not following this item'
                        );
                    }
                } else {
                    $result = array(
                        'result' => ApiStatus::ERROR,
                        'error' => 'Cant find follow item'
                    );
                }
            } else {
                $result = array(
                    'result'    => ApiStatus::REQ_LOGIN,
                    'error'     => 'Please login first'
                );
            }
        } else {
            $result = array(
                'result' => ApiStatus::ERROR,
                'error' => 'Follow ID could not be empty'
            );
        }

        $this->renderJSON($result);
    }

    /**
     * Search artists
     */
    public function actionSearch()
    {
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
                        'link'  => 'artist/add/' . $query,
                        'image' => '/images/icon/i-plus-32.png',
                        'name'  => 'Add new Artist',
                        'description' => 'Import from Facebook'
                    ))
                );
            }
        } else {
            $result = array();
        }

        $this->renderJSON($result);
    }

    /**
     * Search artists
     */
    public function actionError()
    {
        // Get request
        $request = Yii::app()->request;
        $query = $request->getQuery('e');
        if ($query) {
            Yii::log($query, 'warning', 'frontend');
        }
        die();
    }

    /**
     * Return messages
     */
    public function actionMessages()
    {
        if (!Yii::app()->user->isGuest) {
            $request = Yii::app()->request;
            $gig_id = $request->getPost('gig_id');
            $artist_id = $request->getPost('artist_id');

            if ($gig_id && $artist_id) {
                $result = array(
                    'result'    => ApiStatus::SUCCESS,
                    'data'      => MessageApi::getList($gig_id, $artist_id)
                );
            } else {
                $result = array(
                    'result'    => ApiStatus::ERROR,
                    'message'   => 'Gig and Artist IDs could not be empty.'
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

    public function actionLive()
    {
        $this->renderJSON(array());
    }
}