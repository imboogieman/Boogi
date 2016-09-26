<?php

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends PHPUnit_Extensions_Selenium2TestCase
{
    public $unique;
    public $uemail;

    /**
     * Sets up before each test method runs.
     * This mainly sets the base URL for the test application.
     */
    protected function setUp()
    {
        $this->unique = time();
        $this->uemail = $this->unique . '@test.com';

        $this->setBrowser('chrome');
        $this->setBrowserUrl(Yii::app()->params['baseUrl']);
    }

    protected function tearDown()
    {
    }

    public function timeout($type = false)
    {
        switch ($type) {
            case 'short':
                $timeout = 200;
                break;
            case 'long':
                $timeout = 10000;
                break;
            default:
                $timeout = 3000;
                break;
        }
        $this->timeouts()->implicitWait($timeout);
    }

    public function register()
    {
        // Go to registration page
        $this->url('/user/register');
        $this->timeout();

        // Try to register
        $this->byCssSelector('#register-name')->value($this->unique);
        $this->byCssSelector('#register-email')->value($this->uemail);
        $this->byCssSelector('#register-password')->value($this->unique);
        $this->byCssSelector('#register')->click();
        $this->timeout('long');
    }

    public function login()
    {
        // Go to login page
        $this->byCssSelector('#menu-login a')->click();
        $this->timeout();

        // Try to login
        $this->byCssSelector('#email')->value($this->uemail);
        $this->byCssSelector('#password')->value($this->unique);
        $this->byCssSelector('#login')->click();
        $this->timeout();
    }

    public function logout()
    {
        // Simply click logout button
        $this->byCssSelector('#menu-logout a')->click();
        $this->timeout();
    }

    public function assertOnHomepage()
    {
        $header = $this->byCssSelector('h1');
        $this->stringContains('save time and money', strtolower($header->text()));
    }

    public function assertOnArtistProfile()
    {
        $header = $this->byCssSelector('h1');
        $this->assertEquals('artist profile', strtolower($header->text()));
    }

    public function assertOnPromoterProfile()
    {
        $header = $this->byCssSelector('h1');
        $this->assertEquals('promoter profile', strtolower($header->text()));
    }

    public function assertOnBookings()
    {
        $header = $this->byCssSelector('h1');
        $this->assertEquals('your bookings', strtolower($header->text()));
    }
}
