<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180503210523 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE registration_teams
          CHANGE scientific_organization scientific_organization VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE registration_teams
          DROP INDEX UNIQ_196882B0B03A8386,
          ADD INDEX IDX_196882B0B03A8386 (created_by_id)');
    }

    public function down(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE registration_teams
          DROP INDEX IDX_196882B0B03A8386,
          ADD UNIQUE INDEX UNIQ_196882B0B03A8386 (created_by_id)');
        $this->addSql('ALTER TABLE registration_teams
          CHANGE scientific_organization scientific_organization VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
