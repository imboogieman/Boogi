<?php

class m131201_100140_add_artist_fbid extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'fb_id', 'bigint(20) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('artist', 'fb_id');
    }
}