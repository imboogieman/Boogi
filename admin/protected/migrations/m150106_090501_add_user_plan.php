<?php

class m150106_090501_add_user_plan extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'plan', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('user', 'plan');
    }
}