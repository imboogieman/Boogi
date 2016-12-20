<?php

class m141009_104612_fix_default_artist_gig_status extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('artist_gig', 'status', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        $this->alterColumn('artist_gig', 'status', 'tinyint(1) DEFAULT 1');
    }
}