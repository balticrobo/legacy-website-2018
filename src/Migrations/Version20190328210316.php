<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190328210316 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE users ADD marketing TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE users DROP marketing');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
