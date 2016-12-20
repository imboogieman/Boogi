<?php

class m140926_114304_add_booking_time extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist_gig', 'start_time', 'time DEFAULT NULL');
        $this->addColumn('artist_gig', 'end_time', 'time DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist_gig', 'start_time');
        $this->dropColumn('artist_gig', 'end_time');
    }
}