<?php

class m161222_155111_add_foregin_key_to_artist extends CDbMigration
{
	public function up()
	{
		$this->getDbConnection()->createCommand("
            ALTER TABLE `artist`
                ADD CONSTRAINT `fk_artist_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ")->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand("
            ALTER TABLE `artist`
                DROP FOREIGN KEY `fk_artist_user`;
        ")->execute();
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}