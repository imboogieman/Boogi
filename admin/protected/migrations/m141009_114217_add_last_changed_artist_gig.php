<?php

class m141009_114217_add_last_changed_artist_gig extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist_gig', 'last_changed', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('artist_gig', 'last_changed');
    }
}