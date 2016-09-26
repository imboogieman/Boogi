<?php

class m150115_204939_user_create_date extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'create_date', 'date DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'create_date');
    }
}