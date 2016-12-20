<?php

class m131015_195439_add_gig_venue_fk extends CDbMigration
{
    public function up()
    {
        $this->addForeignKey('fk_gig_venue_id', 'gig', 'venue_id', 'venue', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_gig_venue_id', 'gig');
    }
}