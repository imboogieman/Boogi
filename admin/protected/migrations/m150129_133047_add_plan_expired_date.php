<?php

class m150129_133047_add_plan_expired_date extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'plan_activated', 'datetime DEFAULT NULL AFTER plan');
    }

    public function down()
    {
        $this->dropColumn('user', 'plan_activated');
    }
}