<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property integer $plan
 * @property string $plan_activated
 * @property string $role
 * @property string $password
 * @property string $reset_hash
 * @property string $reset_datetime
 * @property string $create_date
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Gig[] $gigs
 * @property Promoter[] $promoters
 * @property Artist[] $artists
 *
 * @TODO: Consider refactoring to keep number of methods under 10
 * @TODO: Decrease Overall complexity
 */
class User extends Model
{
    const ROLE_PROMOTER = 1;
    const ROLE_ARTIST = 2;

    public $rememberMe;

    public $loginError;

    private $_identity;

    private $_entity;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password', 'required'),
            array('email', 'email', 'checkMX' => false, 'message' => 'Please enter a valid email!'),
            array('password', 'length', 'max' => 64),
            array('rememberMe', 'boolean'),
            array('timestamp', 'safe'),
            array('id, email, password, timestamp', 'safe', 'on' => 'search'),
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
            'gigs' => array(self::HAS_MANY, 'Gig', 'user_id'),
            'artists' => array(self::HAS_MANY, 'Artist', 'user_id'),
            'promoters' => array(self::HAS_MANY, 'Promoter', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => 'ID',
            'email'         => 'Email',
            'password'      => 'Password',
            'rememberMe'    => 'Remember me next time',
            'timestamp'     => 'Timestamp',
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
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }

        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = 3600 * 24 * 30; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            $this->_entity = $this->_identity->getUser();
            return true;
        } else {
            $this->loginError = $this->_identity->errorCode;
            return false;
        }
    }

    /**
     * Checks if the given password is correct.
     * @param string $password the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password)
    {
        return CPasswordHelper::verifyPassword($password, $this->password);
    }

    /**
     * Generates the password hash.
     * @param string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return CPasswordHelper::hashPassword($password);
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Set random user pass
     * @return string $password
     */
    public function setRandomPass()
    {
        $password = substr(md5(time()), 0, 10);
        $this->password = CPasswordHelper::hashPassword($password);
        return $password;
    }

    /**
     * Set new user pass
     * @param string $password
     * @return bool
     */
    public function setNewPass($password)
    {
        $this->password = CPasswordHelper::hashPassword($password);
        $this->reset_hash = '';
        return $this->save();
    }

    /**
     * Generate reset password link
     * @return bool|string
     */
    public function generateResetPasswordLink()
    {
        $this->reset_hash = md5($this->id . time());
        $this->reset_datetime = date('Y-m-d H:i:s', strtotime('+1 day'));

        if ($this->save()) {
            return '/user/newpass/' . $this->reset_hash;
        }

        return false;
    }

    /**
     * Return User normalized data
     * @param bool $required
     * @param bool $follow
     * @return array
     */
    public function getNormalizedData($required = true, $follow = false)
    {
        $data = array(
            'id'            => $this->id,
            'is_admin'      => $this->isAdmin(),
            'role'          => $this->role,
            'email'         => $this->email,
            'plan'          => UserApi::getPlanName($this->plan),
            'plan_expire'   => $this->planExpire(),
            'date'          => $this->getDate()
        );

        if ($required) {
            $data['artist']     = $this->artist() ? $this->artist()->getNormalizedData($follow) : false;
            $data['promoter']   = $this->promoter() ? $this->promoter()->getNormalizedData($follow) : false;
        }

        return $data;
    }

    /**
     * Return logged promoter
     * @return User $user
     */
    public static function getLogged()
    {
        if (php_sapi_name() == 'cli') {
            return false;
        }

        if ($user_id = Yii::app()->user->getId()) {
            return User::model()->cache(1000, Model::getCacheDependency('user', $user_id))
                ->with('artists', 'promoters')
                ->find('t.id = :id', array(':id' => $user_id));
        }
    }

    /**
     * Check if current user admin
     * @return string
     */
    public function isAdmin()
    {
        return in_array($this->email, array(
            'manti.by@gmail.com',
            'roman@wemade.biz',
            'djchantcharmant@gmail.com'
        ));
    }

    /**
     * Return logged promoter
     * @return User $user
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * @return Artist $artist
     * @TODO: Decrease NPath complexity
     */
    public function artist()
    {
        if (!empty($this->artists) && isset($this->artists[0])) {
            return $this->artists[0];
        } else {
            $artist = new Artist();
            $promoter = $this->promoter();

            $artist->user_id = $this->id;
            $artist->name = $promoter->name;
            $artist->image = $promoter->image;
            $artist->latitude = $promoter->latitude ? $promoter->latitude : Model::getDefaultLatitude();
            $artist->longitude = $promoter->longitude ? $promoter->longitude : Model::getDefaultLongitude();
            $artist->fb_id = $promoter->fb_id ? $promoter->fb_id : null;

            $transaction = $artist->dbConnection->beginTransaction();
            if ($artist->save()) {
                $transaction->commit();
                return $artist;
            } else {
                foreach ($artist->getErrors() as $error) {
                    Yii::log('Artist::' . $error['field'] . ' - ' . $error['message'], CLogger::LEVEL_ERROR, 'email');
                }
                return false;
            }
        }
    }

    /**
     * @return Promoter $promoter
     * @TODO: Decrease NPath complexity
     */
    public function promoter()
    {
        if (!empty($this->promoters) && isset($this->promoters[0])) {
            return $this->promoters[0];
        } else {
            $artist = $this->artist();
            $promoter = new Promoter();

            $promoter->user_id = $this->id;
            $promoter->name = $artist->name;
            $promoter->image = $artist->image;
            $promoter->latitude = $artist->latitude ? $artist->latitude : Model::getDefaultLatitude();
            $promoter->longitude = $artist->longitude ? $artist->longitude : Model::getDefaultLongitude();
            $promoter->radius = Model::getDefaultRadius();
            $promoter->fb_id = $artist->fb_id ? $artist->fb_id : null;

            $transaction = $promoter->dbConnection->beginTransaction();
            if ($promoter->save()) {
                $transaction->commit();
                return $promoter;
            } else {
                foreach ($promoter->getErrors() as $error) {
                    Yii::log('Artist::' . $error['field'] . ' - ' . $error['message'], CLogger::LEVEL_ERROR, 'email');
                }
                return false;
            }
        }
    }

    public function is_promoter()
    {
        return $this->role == self::ROLE_PROMOTER ? true : false;
    }

    public static function getCurrentLatitude()
    {
        if (isset(Yii::app()->request->cookies['latitude']) &&
            !empty(Yii::app()->request->cookies['latitude']->value)) {
            return Yii::app()->request->cookies['latitude']->value;
        } else {
            return Model::getDefaultLatitude();
        }
    }

    public static function getCurrentLongitude()
    {
        if (isset(Yii::app()->request->cookies['longitude']) &&
            !empty(Yii::app()->request->cookies['longitude']->value)) {
            return Yii::app()->request->cookies['longitude']->value;
        } else {
            return Model::getDefaultLongitude();
        }
    }

    public static function getCurrentRadius()
    {
        if (isset(Yii::app()->request->cookies['radius']) &&
            !empty(Yii::app()->request->cookies['radius']->value)) {
            return Yii::app()->request->cookies['radius']->value;
        } else {
            return Model::getDefaultRadius();
        }
    }

    public function planExpire()
    {
        if ($this->plan_activated) {
            return date('Y-m-d', strtotime('+1 month', strtotime($this->plan_activated)));
        }
        return date('Y-m-d', strtotime('+1 month', strtotime($this->create_date)));
    }
}
