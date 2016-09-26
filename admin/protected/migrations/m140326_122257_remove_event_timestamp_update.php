<?php

class m140326_122257_remove_event_timestamp_update extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('event', 'timestamp', 'timestamp NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->alterColumn('event', 'timestamp', 'timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }
}