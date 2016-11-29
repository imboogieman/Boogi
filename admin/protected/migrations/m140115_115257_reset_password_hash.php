<?php

class m140115_115257_reset_password_hash extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'reset_hash', 'varchar(32) DEFAULT NULL');
        $this->addColumn('user', 'reset_datetime', 'datetime DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'reset_hash');
        $this->dropColumn('user', 'reset_datetime');
    }
}