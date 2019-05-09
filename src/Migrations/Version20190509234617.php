<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190509234617 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events ADD volunteer_registration TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events DROP volunteer_registration');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
