<?php

class m140113_150316_promoter_promoter extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `promoter_promoter` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `promoter_id` int(11) NOT NULL,
              `follow_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_promoter_promoter_id` (`promoter_id`),
              KEY `fk_promoter_follow_id` (`follow_id`),
              CONSTRAINT `fk_promoter_promoter_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_promoter_follow_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('promoter_promoter');
    }
}