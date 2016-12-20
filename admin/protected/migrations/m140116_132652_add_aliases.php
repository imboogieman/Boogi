<?php

class m140116_132652_add_aliases extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'alias', 'varchar(64) DEFAULT NULL');
        $this->addColumn('promoter', 'alias', 'varchar(64) DEFAULT NULL');
        $this->addColumn('venue', 'alias', 'varchar(64) DEFAULT NULL');
        $this->addColumn('gig', 'alias', 'varchar(64) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist', 'alias');
        $this->dropColumn('promoter', 'alias');
        $this->dropColumn('venue', 'alias');
        $this->dropColumn('gig', 'alias');
    }
}