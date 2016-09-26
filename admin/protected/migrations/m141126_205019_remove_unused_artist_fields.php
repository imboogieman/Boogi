<?php

class m141126_205019_remove_unused_artist_fields extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('artist', 'sc_name');
        $this->dropColumn('artist', 'gt_name');
        $this->dropColumn('artist', 'tw_name');
        $this->dropColumn('artist', 'mc_name');
        $this->dropColumn('artist', 'bp_id');
    }

    public function down()
    {
        $this->addColumn('artist', 'sc_name', 'varchar(255) DEFAULT NULL');
        $this->addColumn('artist', 'gt_name', 'varchar(255) DEFAULT NULL');
        $this->addColumn('artist', 'tw_name', 'varchar(255) DEFAULT NULL');
        $this->addColumn('artist', 'mc_name', 'varchar(255) DEFAULT NULL');
        $this->addColumn('artist', 'bp_id', 'bigint(20) DEFAULT NULL');
    }
}