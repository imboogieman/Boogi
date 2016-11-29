<?php

class m140710_201905_migrate_files extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            UPDATE file
            SET path = REPLACE(path, 'images/', 'images/storage/');
        ")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand("
            UPDATE file
            SET path = REPLACE(path, 'storage/', '');
        ")->execute();
    }
}