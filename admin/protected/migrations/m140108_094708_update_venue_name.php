<?php

class m140108_094708_update_venue_name extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            UPDATE `venue` v
            SET v.`name` = CONCAT((SELECT c.`name` FROM `country` c WHERE c.`id` = v.`country_id`), ' / ', v.`city`)
            WHERE v.`name` = '' OR v.`name` IS NULL
        ")->execute();
    }

    public function down()
    {
    }
}