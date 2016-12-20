<?php
	class Companies extends Model
	{
		/**
		 * @return string the associated database table name
		 */
		public function tableName()
		{
			return 'companies';
		}

		/**
		 * @return array validation rules for model attributes.
		 */
//		public function rules()
//		{
//			// NOTE: you should only define rules for those attributes that
//			// will receive user inputs.
//			return array(
//				array('user_id, name', 'required'),
//				array('user_id', 'numerical', 'integerOnly' => true),
//				array('name', 'length', 'max' => 64),
//				array('description, timestamp', 'safe'),
//				array('radius, latitude, longitude', 'numerical'),
//				array('is_approved, fb_id', 'numerical', 'integerOnly' => true),
//				array('fb_id', 'length', 'max' => 64),
//				array('id, is_approved, name, latitude, longitude, radius, fb_id', 'safe', 'on' => 'search'),
//				array('address', 'length', 'max' => 255),
//				array('homepage', 'length', 'max' => 255),
//				array('description', 'string'),
//				array('page', 'length', 'max' => 64),
//				array('genres', 'length', 'max' => 256),
//				array('experience', 'length', 'max' => 128),
//				array('f_artists', 'length', 'max' => 256),
//			);
//		}
	}