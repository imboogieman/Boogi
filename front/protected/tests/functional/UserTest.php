<?php

class UserTest extends WebTestCase
{
    /**
     * @group User
     */
    public function testRegisterPromoter()
    {
        // Register new user
        $this->register();

        // Check that we are in Promoter profile
        $this->assertOnPromoterProfile();
    }

    /**
     * @group User
     */
    public function testLoginLogoutPromoter()
    {
        // Register new user
        $this->register();

        // Check that we are in Promoter profile
        $this->assertOnPromoterProfile();

        // Click logout
        $this->logout();

        // Check that we are on home page
        $this->assertOnHomepage();

        // Try to login
        $this->login();

        // Check that we are on booking page
        $this->assertOnBookings();
    }
}
