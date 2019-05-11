<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190511182726 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE registration_teams_hackathon ADD chosen TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE registration_teams_hackathon DROP chosen');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
