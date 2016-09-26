<?php

class m140329_131324_add_user_role extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'role', 'tinyint(2) DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn('user', 'role');
    }
}