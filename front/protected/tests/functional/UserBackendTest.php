<?php
	use PHPUnit\Framework\TestCase;

	class UserBackEndTest extends TestCase {
		protected $fixture;

		protected function setUp()
		{
//			$this->fixture = new MyClass ();
		}

		protected function tearDown()
		{
//			$this->fixture = NULL;
		}

		/**
		 * @dataProvider testArtist
		 */
		public function testArtist()
		{
			$email = 'info@boogi.co';
			$user = User::model()->find('email = :email', array(':email' => $email));
			$this->assertFalse($user->artist());
		}

		/**
		 * @dataProvider testArtist1
		 */
		public function testArtist1()
		{
			$email = 'djchantcharmant@gmail.com';
			$user = User::model()->find('email = :email', array(':email' => $email));
			$this->assertInstanceOf(Artist::class, $user->artist());
		}
	}