<?php

class m131015_110952_file_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `file` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `path` varchar(255) DEFAULT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('file');
    }
}
