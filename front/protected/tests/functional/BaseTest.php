<?php
require_once 'front/protected/tests/WebTestCase.php';

class BaseTest extends WebTestCase
{
    /**
     * @group Pages
     */
    public function testIndex()
    {
        // Go to home page
        $this->url('/');
        $this->timeout();

        // Check that we are on home page
        $this->assertOnHomepage();
    }

    /**
     * @group Pages
     */
    public function testContact()
    {
        // Go to contact page
        $this->url('/contact');
        $this->timeout();

        // Fill and submit subscribe form
        $this->byCssSelector('#contact-name')->value($this->unique);
        $this->byCssSelector('#contact-email')->value($this->uemail);
        $this->byCssSelector('#contact-message')->value($this->unique);
        $this->byCssSelector('#contact')->click();
        $this->timeout();

        // Check that we are on home page
        $this->assertOnHomepage();
    }

    /**
     * @group Pages
     */
    public function testAbout()
    {
        // Go to about page
        $this->url('/about');
        $this->timeout();

        // Check About page title
        $header = $this->byCssSelector('h1');
        $this->stringContains('About Us', $header->text());
    }

    /**
     * @group Pages
     */
    public function testTC()
    {
        //  Go to TC page
        $this->url('/terms');
        $this->timeout();

        // Check TC page title
        $header = $this->byCssSelector('h1');
        $this->stringContains('Terms and Conditions', $header->text());
    }
}
