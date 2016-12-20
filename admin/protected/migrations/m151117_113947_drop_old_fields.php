<?php

class m151117_113947_drop_old_fields extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('gig', 'datetime');
        $this->dropColumn('artist_gig', 'start_time');
        $this->dropColumn('artist_gig', 'end_time');
    }

    public function down()
    {
        $this->addColumn('gig', 'datetime', 'datetime DEFAULT NULL');
        $this->addColumn('artist_gig', 'start_time', 'time DEFAULT NULL');
        $this->addColumn('artist_gig', 'end_time', 'time DEFAULT NULL');
    }
}