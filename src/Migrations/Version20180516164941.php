<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180516164941 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events
          ADD registration_stops_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'');
    }

    public function down(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events DROP registration_stops_at');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
