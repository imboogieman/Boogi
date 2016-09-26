<?php

class m140326_092952_add_event_name_and_link extends CDbMigration
{
    public function up()
    {
        $this->addColumn('event', 'init_name', 'varchar(64) DEFAULT NULL');
        $this->addColumn('event', 'init_link', 'varchar(255) DEFAULT NULL');
        $this->addColumn('event', 'target_name', 'varchar(64) DEFAULT NULL');
        $this->addColumn('event', 'target_link', 'varchar(255) DEFAULT NULL');
        $this->addColumn('event', 'creator_name', 'varchar(64) DEFAULT NULL');
        $this->addColumn('event', 'creator_link', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('event', 'init_name');
        $this->dropColumn('event', 'init_link');
        $this->dropColumn('event', 'target_name');
        $this->dropColumn('event', 'target_link');
        $this->dropColumn('event', 'creator_name');
        $this->dropColumn('event', 'creator_link');
    }
}