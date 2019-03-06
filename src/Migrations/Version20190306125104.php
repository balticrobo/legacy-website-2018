<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190306125104 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE competitions ADD sort_order SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE competitions DROP sort_order');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
