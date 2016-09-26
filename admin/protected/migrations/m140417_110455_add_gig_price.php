<?php

class m140417_110455_add_gig_price extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'price', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('gig', 'price');
    }
}