<?php


	class APIUserTest extends PHPUnit_Framework_TestCase{

		public $unique;
		public $uemail;

		protected function setUp()
		{
			$this->unique = time();
			$this->uemail = 'babakband@boogi.co';
		}

		public function testEmpty() {
			$user = User::model()->find('email = :email', array(':email' => $this->uemail));
			$this->assertNotEmpty($user);

			return $user;
		}
	}