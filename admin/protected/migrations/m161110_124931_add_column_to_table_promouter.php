<?php

class m161110_124931_add_column_to_table_promouter extends CDbMigration
{
	public function up()
	{
		$this->getDbConnection()->createCommand("
            ALTER TABLE `promoter`
                ADD `page` varchar(64) AFTER `homepage`,
                ADD `genres` varchar(256) AFTER `homepage`,
                ADD `experience` varchar(128) AFTER `homepage`,
                ADD `f_artists` varchar(256) AFTER `homepage`
        ")->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand("
            ALTER TABLE `promoter`
                DROP `page`,
                DROP `genres`,
                DROP `experience`,
                DROP `f_artists`,
                DROP `company_id`,
                DROP FOREIGN KEY `fk_promoter_companies`
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