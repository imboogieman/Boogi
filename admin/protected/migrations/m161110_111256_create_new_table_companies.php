<?php

class m161110_111256_create_new_table_companies extends CDbMigration
{
	public function up()
	{
		$this->getDbConnection()->createCommand("
            CREATE TABLE `companies` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `promoter_id` int(11) NOT NULL,
              `name` varchar(64) NOT NULL,
              `category` varchar(64) NOT NULL,
              `address` varchar(128),
              `founding_date` date,
              `phone` int(11) NOT NULL,
              `website` varchar(64),
              `description` text,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_companies_promoter` (`promoter_id`),
              CONSTRAINT `fk_companies_promoter` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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