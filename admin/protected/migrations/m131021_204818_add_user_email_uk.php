<?php

class m131021_204818_add_user_email_uk extends CDbMigration
{
    public function up()
    {
        $this->createIndex('uk_user_email', 'user', 'email', true);
    }

    public function down()
    {
        $this->dropIndex('user', 'email');
    }
}