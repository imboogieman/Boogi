<?php

class m140313_090944_add_gig_currency extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'currency', 'tinyint(1) DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn('gig', 'currency');
    }
}