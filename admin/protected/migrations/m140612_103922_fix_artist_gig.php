<?php

class m140612_103922_fix_artist_gig extends CDbMigration
{
    public function up()
    {
        $this->addPrimaryKey('pk_artist_gig_id', 'artist_gig', 'id');
        $this->alterColumn('artist_gig', 'id', 'int(11) NOT NULL AUTO_INCREMENT FIRST');

        $this->addForeignKey('fk_artist_gig_artist_id', 'artist_gig', 'artist_id', 'artist', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_artist_gig_gig_id', 'artist_gig', 'gig_id', 'gig', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_artist_gig_artist_id', 'artist_gig');
        $this->dropForeignKey('fk_artist_gig_gig_id', 'artist_gig');

        $this->dropPrimaryKey('pk_artist_gig_id', 'artist_gig', 'id');
        $this->alterColumn('artist_gig', 'id', 'int(11) NOT NULL');
    }
}