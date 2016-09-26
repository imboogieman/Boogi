<?php

class m140528_141959_fix_event_links extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            UPDATE event SET init_link = REPLACE(init_link, '#', '');
            UPDATE event SET target_link = REPLACE(target_link, '#', '');
            UPDATE event SET creator_link = REPLACE(creator_link, '#', '');
            UPDATE event SET init_link = REPLACE(init_link, 'artist/', '');
            UPDATE event SET target_link = REPLACE(target_link, 'artist/', '');
            UPDATE event SET creator_link = REPLACE(creator_link, 'artist/', '');
        ")->execute();
    }

    public function down()
    {
    }
}