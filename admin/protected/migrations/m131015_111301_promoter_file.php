<?php

class m131015_111301_promoter_file extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `promoter_file` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `promoter_id` int(11) NOT NULL,
              `file_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_promoter_file_promoter_id` (`promoter_id`),
              KEY `fk_promoter_file_file_id` (`file_id`),
              CONSTRAINT `fk_promoter_file_promoter_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_promoter_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('promoter_file');
    }
}
