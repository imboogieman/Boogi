<?php

class m131203_123520_add_artist_ids extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'sc_name', 'varchar(255) DEFAULT NULL');
        $this->addColumn('artist', 'gt_name', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist', 'sc_name');
        $this->dropColumn('artist', 'gt_name');
    }
}