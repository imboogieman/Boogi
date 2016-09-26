<?php

class m131018_135756_update_password_length extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('user', 'password', 'varchar(64) NOT NULL');
    }

    public function down()
    {
        $this->alterColumn('user', 'password', 'varchar(32) NOT NULL');
    }
}