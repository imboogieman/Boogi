<?php

class m140104_222841_fix_gig_user_id extends CDbMigration
{
    public function up()
    {
        $this->dropForeignKey('fk_gig_user_id', 'gig');
        $this->alterColumn('gig', 'name', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('gig', 'user_id', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->alterColumn('gig', 'name', 'varchar(64) NOT NULL');
        $this->alterColumn('gig', 'user_id', 'int(11) NOT NULL');
        $this->addForeignKey('fk_gig_user_id', 'gig', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }
}