<?php

class UserTest extends WebTestCase
{
    /**
     * @group User
     */
    public function testLoginLogoutPromoterByFacebook()
    {
        // Register new user
        $this->register();
		sleep(5);
        // Check that we are in Promoter profile
        $this->assertOnPromoterProfile();

        // Click logout
        $this->logout();
	    sleep(1);
        // Check that we are on home page
        $this->assertOnHomepage();
    }
}
