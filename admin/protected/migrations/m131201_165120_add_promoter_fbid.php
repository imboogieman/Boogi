<?php

class m131201_165120_add_promoter_fbid extends CDbMigration
{
    public function up()
    {
        $this->addColumn('promoter', 'fb_id', 'bigint(20) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('promoter', 'fb_id');
    }
}