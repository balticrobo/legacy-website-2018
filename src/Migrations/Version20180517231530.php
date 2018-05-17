<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180517231530 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events
          MODIFY COLUMN registration_stops_at int(11) NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'
            AFTER registration_starts_at');
    }

    public function down(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events
          MODIFY COLUMN registration_stops_at int(11) NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'
            AFTER draft');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
