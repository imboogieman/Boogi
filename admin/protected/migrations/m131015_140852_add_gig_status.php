<?php

class m131015_140852_add_gig_status extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'status', 'tinyint(1) NULL DEFAULT 0 AFTER `datetime`');
    }

    public function down()
    {
        $this->dropColumn('gig', 'status');
    }
}
