<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $id
 * @property string $type
 * @property integer $status
 * @property integer $is_active
 * @property string $init_type
 * @property integer $init_id
 * @property string $init_name
 * @property string $init_link
 * @property string $target_type
 * @property integer $target_id
 * @property string $target_name
 * @property string $target_link
 * @property string $creator_type
 * @property integer $creator_id
 * @property string $creator_name
 * @property string $creator_link
 * @property integer $email_status
 * @property integer $email_attempts
 * @property string $datetime
 * @property string $timestamp
 *
 * @TODO: Decrease Overall complexity
 */
class Event extends Model
{
    const BOOKING_UPDATE    = 1; // Booking status updated
    const BOOKING_CREATE    = 2; // New booking created
    const BOOKING_TRACK     = 3; // Booking notification for followers

    const ARTIST_CREATE     = 4; // New artist
    const ARTIST_TRACK      = 5; // New artist notification for followers

    const GIG_CREATE        = 6; // New gig notification for artist followers

    const PROMOTER_CREATE   = 7; // New promoter

    const FOLLOW_PROMOTER   = 8; // Promoter follow promoter
    const UNFOLLOW_PROMOTER = 9; // Promoter unfollow promoters

    const FOLLOW_ARTIST     = 10; // Promoter follow artist
    const UNFOLLOW_ARTIST   = 11; // Promoter unfollow artist

    const EMAIL_NOT_SENT    = 0;
    const EMAIL_SENT        = 1;
    const EMAIL_SKIP        = 2;
    const EMAIL_ERROR       = 3;

    const PROMOTER_GIG_UPDATE = 12;
    const PROMOTER_BOOKING_UPDATE = 13;
    const ARTIST_BOOKING_UPDATE = 14;

    const EMAIL_MAX_SEND_ATTEMPTS = 3;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'event';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, init_type, init_id, target_type, target_id', 'required'),
            array('status, init_id, target_id, creator_id, email_status', 'numerical', 'integerOnly' => true),
            array('type, init_type, init_name, target_type, target_name, creator_type, creator_name', 'length', 'max' => 64),
            array('type, init_link, target_link, creator_link', 'length', 'max' => 255),
            array('timestamp', 'safe'),
            array('id, type, init_type, init_id, target_type, target_id, creator_type, creator_id, datetime, timestamp', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'type' => 'Type',
            'status' => 'Status',
            'init_type' => 'Init Type',
            'init_id' => 'Init',
            'init_name' => 'Init Name',
            'init_link' => 'Init Link',
            'target_type' => 'Target Type',
            'target_id' => 'Target',
            'target_name' => 'Target Name',
            'target_link' => 'Target Link',
            'creator_type' => 'Creator Type',
            'creator_name' => 'Creator Name',
            'creator_link' => 'Creator Link',
            'creator_id' => 'Creator',
            'datetime' => 'Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('init_type', $this->init_type, true);
        $criteria->compare('init_id', $this->init_id);
        $criteria->compare('target_type', $this->target_type, true);
        $criteria->compare('target_id', $this->target_id);
        $criteria->compare('creator_type', $this->creator_type, true);
        $criteria->compare('creator_id', $this->creator_id);
        $criteria->compare('datetime', $this->datetime, true);

        return new CActiveDataProvider($this, array(
            'criteria'  => $criteria,
            'sort'      => array(
                'defaultOrder' => 'datetime DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Event the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Return event normalized data
     * @param bool $required
     * @param bool $cascade
     * @param bool $is_follow
     * @return array $data
     * @TODO: Decrease Cyclomatic complexity
     */
    public function getNormalizedData($required = true, $cascade = true, $is_follow = false)
    {
        $data = array(
            'id' => $this->id,
            'init' => array(
                'id'    => $this->init_id,
                'link'  => $this->init_link,
                'name'  => $this->init_name,
                'deleted' => 0,
            ),
            'target' => array(
                'id'    => $this->target_id,
                'link'  => $this->target_link,
                'name'  => $this->target_name,
                'deleted' => 0,
            ),
            'creator' => array(
                'id'    => $this->creator_id,
                'link'  => $this->creator_link,
                'name'  => $this->creator_name,
                'deleted' => 0,
            ),
            'type'          => $this->type,
            'status'        => $this->status,
            'type_string'   => $this->getType($is_follow),
            'date'          => $this->getDate(),
            'timestamp'     => $this->timestamp,
            'hash'          => $this->type . '-' . $this->init_id . '-' . $this->target_id
        );

        if ($required) {
            if ($this->init_type && $this->init_id) {
                $init = call_user_func(array($this->init_type, 'model'))->findByPk($this->init_id);
                if ($init) {
                    $data['init'] = $init->getNormalizedData($cascade);
                    $data['init']['deleted'] = 0;
                } else {
                    $data['init']['deleted'] = 1;
                }
            }

            if ($this->target_type && $this->target_id) {
                $target = call_user_func(array($this->target_type, 'model'))->findByPk($this->target_id);
                if ($target) {
                    $data['target'] = $target->getNormalizedData($cascade);
                    $data['target']['deleted'] = 0;
                } else {
                    $data['target']['deleted'] = 1;
                }
            }

            if ($this->creator_type && $this->creator_id) {
                $creator = call_user_func(array($this->creator_type, 'model'))->findByPk($this->creator_id);
                if ($creator) {
                    $data['creator'] = $creator->getNormalizedData($cascade);
                    $data['creator']['deleted'] = 0;
                } else {
                    $data['creator']['deleted'] = 1;
                }
            }
        }
        return $data;
    }

    /**
     * Return human readable text for type
     * @param bool $is_follow
     * @return string
     * @TODO: Decrease Cyclomatic complexity
     */
    public function getType($is_follow = false)
    {
        if ($is_follow) {
            switch ($this->type) {
                case Event::BOOKING_UPDATE:
                    return 'whom you track accept booking';
                case Event::BOOKING_CREATE:
                    return 'whom you track book artist';
                case Event::BOOKING_TRACK:
                    if ($this->creator_type && $this->creator_id) {
                        $follow = call_user_func(array($this->creator_type, 'model'))->findByPk($this->creator_id);
                        return 'from tracked promoter <a href="' . $follow->link . '">' . $follow->name . '</a> add new booking';
                    }
                    return 'from tracked promoter, add new booking';
                case Event::ARTIST_CREATE:
                    return 'whom you track create artist';
                case Event::ARTIST_TRACK:
                    if ($this->creator_type && $this->creator_id) {
                        $follow = call_user_func(array($this->creator_type, 'model'))->findByPk($this->creator_id);
                        return 'from tracked promoter <a href="' . $follow->link . '">' . $follow->name . '</a>, add new booking';
                    }
                    return 'from tracked promoter add new gig';
                case Event::GIG_CREATE:
                    return 'whom you track create gig';
                case Event::PROMOTER_CREATE:
                    return 'whom you track create promoter';
                case Event::FOLLOW_ARTIST:
                    return 'whom you track follow artist';
                case Event::FOLLOW_PROMOTER:
                    return 'whom you track follow promoter';
                case Event::UNFOLLOW_ARTIST:
                    return 'whom you track now not following artist';
                case Event::UNFOLLOW_PROMOTER:
                    return 'whom you track now not following promoter';
                case Event::PROMOTER_GIG_UPDATE:
                    return 'whom you track updated gig details on';
                case Event::PROMOTER_BOOKING_UPDATE:
                    return 'whom you track updated booking details on';
                case Event::ARTIST_BOOKING_UPDATE:
                    return 'whom you track updated booking details on';
            }
        } else {
            switch ($this->type) {
                case Event::BOOKING_UPDATE:
                    return 'accept booking';
                case Event::BOOKING_CREATE:
                    return 'book artist';
                case Event::BOOKING_TRACK:
                    return 'whom you track add new booking';
                case Event::ARTIST_CREATE:
                    return 'create artist';
                case Event::ARTIST_TRACK:
                    return 'whom you track add new gig';
                case Event::GIG_CREATE:
                    return 'create gig';
                case Event::PROMOTER_CREATE:
                    return 'create promoter';
                case Event::FOLLOW_ARTIST:
                    return 'follow artist';
                case Event::FOLLOW_PROMOTER:
                    return 'follow promoter';
                case Event::UNFOLLOW_ARTIST:
                    return 'now not following artist';
                case Event::UNFOLLOW_PROMOTER:
                    return 'now not following promoter';
                case Event::PROMOTER_GIG_UPDATE:
                    return 'updated gig details on';
                case Event::PROMOTER_BOOKING_UPDATE:
                    return 'updated booking details on';
                case Event::ARTIST_BOOKING_UPDATE:
                    return 'updated booking details on';
            }
        }
        return null;
    }

    /**
     * Return human readable text for type
     * @param array $data
     * @return string
     * @TODO: Decrease Cyclomatic complexity
     */
    public static function getTypeById($data)
    {
        if ($data['is_followed']) {
            switch ($data['type']) {
                case Event::BOOKING_UPDATE:
                    return 'whom you track accept booking';
                case Event::BOOKING_CREATE:
                    return 'whom you track book artist';
                case Event::BOOKING_TRACK:
                    if (!empty($data['follow_link']) && !empty($data['follow_name'])) {
                        return 'from tracked promoter <a href="' . $data['follow_link'] . '">' . $data['follow_name'] . '</a> add new booking';
                    }
                    return 'from tracked promoter, add new booking';
                case Event::ARTIST_CREATE:
                    return 'whom you track add new artist';
                case Event::ARTIST_TRACK:
                    if (!empty($data['follow_link']) && !empty($data['follow_name'])) {
                        return 'from tracked promoter <a href="' . $data['follow_link'] . '">' . $data['follow_name'] . '</a>, add new booking';
                    }
                    return 'from tracked promoter add new gig';
                case Event::GIG_CREATE:
                    return 'whom you track add new gig';
                case Event::PROMOTER_CREATE:
                    return 'whom you track create promoter';
                case Event::FOLLOW_ARTIST:
                    return 'whom you track follow artist';
                case Event::FOLLOW_PROMOTER:
                    return 'whom you track follow promoter';
                case Event::UNFOLLOW_ARTIST:
                    return 'whom you track now not following artist';
                case Event::UNFOLLOW_PROMOTER:
                    return 'whom you track now not following promoter';
                case Event::PROMOTER_GIG_UPDATE:
                    return 'whom you track updated gig details on';
                case Event::PROMOTER_BOOKING_UPDATE:
                    return 'whom you track updated booking details on';
                case Event::ARTIST_BOOKING_UPDATE:
                    return 'whom you track updated booking details on';
            }
        } else {
            switch ($data['type']) {
                case Event::BOOKING_UPDATE:
                    return 'accept booking';
                case Event::BOOKING_CREATE:
                    return 'book artist';
                case Event::BOOKING_TRACK:
                    return 'whom you track add new booking';
                case Event::ARTIST_CREATE:
                    return 'add new artist';
                case Event::ARTIST_TRACK:
                    return 'whom you track add new gig';
                case Event::GIG_CREATE:
                    return 'add new gig';
                case Event::PROMOTER_CREATE:
                    return 'add new promoter';
                case Event::FOLLOW_ARTIST:
                    return 'follow artist';
                case Event::FOLLOW_PROMOTER:
                    return 'follow promoter';
                case Event::UNFOLLOW_ARTIST:
                    return 'now not following artist';
                case Event::UNFOLLOW_PROMOTER:
                    return 'now not following promoter';
                case Event::PROMOTER_GIG_UPDATE:
                    return 'updated gig details on';
                case Event::PROMOTER_BOOKING_UPDATE:
                    return 'updated booking details on';
                case Event::ARTIST_BOOKING_UPDATE:
                    return 'updated booking details on';
            }
        }
        return null;
    }

    public function getInitLink()
    {
        if ($this->init_type && $this->init_id) {
            $class = $this->init_type;
            $init = $class::model($class)->findByPk($this->init_id);
            $name = isset($init->name) ? $init->name : $this->init_name;
            return CHtml::link($name, array(strtolower($this->init_type) . '/view', 'id' => $init->id));
        }
        return null;
    }

    public function getTargetLink()
    {
        if ($this->target_type && $this->target_id) {
            $class = $this->target_type;
            $target = $class::model($class)->findByPk($this->target_id);
            $name = isset($target->name) ? $target->name : $this->target_name;
            return CHtml::link($name, array(strtolower($this->target_type) . '/view', 'id' => $target->id));
        }
        return null;
    }

    public function getCreatorLink()
    {
        if ($this->creator_type && $this->creator_id) {
            $class = $this->creator_type;
            $creator = $class::model($class)->findByPk($this->creator_id);
            $name = isset($creator->name) ? $creator->name : $this->creator_name;
            return CHtml::link($name, array(strtolower($this->creator_type) . '/view', 'id' => $creator->id));
        }
        return null;
    }

    public function getEmailLink()
    {
        return CHtml::link('Email #' . $this->id, 'site/email?id=' . $this->id, array('target' => '_blank'));
    }

    // @TODO: Decrease Cyclomatic complexity
    public static function getDummyData($type)
    {
        switch ($type) {
            case Event::BOOKING_UPDATE:
                return array(
                    'template'      => 'email/booking-update',
                    'promoter'      => 'PROMOTER',
                    'gig'           => 'GIG',
                    'link'          => '',
                    'date'          => 'DD.MM.YY'
                );
                break;
            case Event::BOOKING_CREATE:
                return array(
                    'template'      => 'email/booking-create',
                    'promoter'      => 'PROMOTER',
                    'artist'        => 'ARTIST',
                    'link'          => '',
                    'gig'           => 'GIG',
                    'gig_link'      => '',
                    'date'          => 'DD.MM.YY'
                );
                break;
            case Event::BOOKING_TRACK:
                return array(
                    'template'      => 'email/booking-track',
                    'promoter'      => 'PROMOTER',
                    'artist'        => 'ARTIST',
                    'link'          => '',
                    'follow'        => 'FOLLOW',
                    'follow_link'   => ''
                );
                break;
            case Event::FOLLOW_ARTIST:
            case Event::FOLLOW_PROMOTER:
                return array(
                    'template'      => 'email/follow',
                    'promoter'      => 'PROMOTER',
                    'follow'        => 'FOLLOWER',
                    'follow_link'   => '',
                    'target'        => 'TARGET',
                    'target_link'   => '',
                );
                break;
            case Event::UNFOLLOW_ARTIST:
            case Event::UNFOLLOW_PROMOTER:
                return array(
                    'template'      => 'email/unfollow',
                    'promoter'      => 'PROMOTER',
                    'follow'        => 'FOLLOWER',
                    'follow_link'   => '',
                    'target'        => 'TARGET',
                    'target_link'   => '',
                );
                break;
            case Event::ARTIST_TRACK:
                return array(
                    'template'      => 'email/artist-track',
                    'promoter'      => 'PROMOTER',
                    'artist'        => 'ARTIST',
                    'link'          => '',
                    'gig'           => 'GIG',
                    'gig_link'      => ''
                );
                break;
            case Event::GIG_CREATE:
                return array(
                    'template'      => 'email/gig-create',
                    'promoter'      => 'PROMOTER',
                    'name'          => 'PROMOTER',
                    'gig'           => 'GIG',
                    'link'          => ''
                );
                break;
            case Event::PROMOTER_CREATE:
                return array(
                    'template'      => 'email/promoter-create',
                    'promoter'      => 'PROMOTER',
                    'name'          => 'NEWPROMOTER',
                    'link'          => '',
                );
                break;
            case Event::ARTIST_CREATE:
            default:
                return array(
                    'template'      => 'email/artist-create',
                    'promoter'      => 'PROMOTER',
                    'name'          => 'NEWARTIST',
                    'link'          => '',
                );
                break;
        }
    }

    public function updateData()
    {
        // Get full data
        $data = $this->getNormalizedData(true, false);

        // Check if exists
        if ($data['init']['deleted'] || $data['target']['deleted']) {
            $this->delete();
            return Model::STATUS_DELETED;
        }

        // Update fields
        if (!$this->init_name || !$this->target_name) {
            $this->init_name = $data['init']['name'];
            $this->init_link = $data['init']['link'];
            $this->target_name = $data['target']['name'];
            $this->target_link = $data['target']['link'];

            if (isset($data['creator'])) {
                $this->creator_name = $data['creator']['name'];
                $this->creator_link = $data['creator']['link'];
            }

            return $this->save() ? Model::STATUS_UPDATED : Model::STATUS_ERROR;
        }

        return Model::STATUS_SKIPPED;
    }

    public function delete()
    {
        $this->status = 0;
        return $this->save();
    }

    /**
     * Return formatted date for object timestamp
     * @param string $format
     * @return string
     */
    public function getDate($format = 'D, d M Y')
    {
        return $this->datetime ? date($format, strtotime($this->datetime)) : '';
    }
}
