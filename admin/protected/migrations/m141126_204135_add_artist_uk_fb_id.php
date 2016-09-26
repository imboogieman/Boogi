<?php

class m141126_204135_add_artist_uk_fb_id extends CDbMigration
{
    public function up()
    {
        $this->createIndex('uk_artist_fb_id', 'artist', 'fb_id', true);
    }

    public function down()
    {
        $this->dropIndex('uk_artist_fb_id', 'artist');
    }
}