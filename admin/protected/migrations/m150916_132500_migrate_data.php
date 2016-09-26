<?php

class m150916_132500_migrate_data extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            UPDATE gig g SET g.datetime_from = g.datetime, g.datetime_to = g.datetime, g.timezone = 'Europe/London',
              g.address = (SELECT v.address FROM venue v WHERE v.id = g.venue_id), currency = 1
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE gig SET capacity = 100 WHERE capacity = 1
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE gig SET capacity = 300 WHERE capacity = 2
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE gig SET capacity = 1000 WHERE capacity = 3
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE gig SET capacity = 5000 WHERE capacity = 4
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE gig SET capacity = 10000 WHERE capacity = 5
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist_gig ag SET
              ag.datetime_from = (SELECT g.datetime_from FROM gig g WHERE g.id = ag.gig_id),
              ag.datetime_to = (SELECT g.datetime_to FROM gig g WHERE g.id = ag.gig_id),
              ag.timezone = 'Europe/London'
        ")->execute();
    }

    public function down()
    {
    }
}