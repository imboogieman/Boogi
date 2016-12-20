<?php

class m150526_105344_add_approved_status extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'is_approved', 'tinyint(1) DEFAULT 0');
        $this->addColumn('promoter', 'is_approved', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('artist', 'is_approved');
        $this->dropColumn('promoter', 'is_approved');
    }
}