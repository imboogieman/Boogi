<?php

class m141009_103936_add_next_day_to_artist_gig extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist_gig', 'next_day', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('artist_gig', 'next_day');
    }
}