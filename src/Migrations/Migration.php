<?php declare(strict_types=1);

namespace BalticRobo\Website\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\AbortMigration;

abstract class Migration extends AbstractMigration
{
    public function preUp(Schema $schema): void
    {
        $this->checkDatabaseType();
    }

    public function preDown(Schema $schema): void
    {
        $this->checkDatabaseType();
    }

    private function checkDatabaseType(): void
    {
        if ('mysql' !== $this->connection->getDatabasePlatform()->getName()) {
            throw new AbortMigration('MySQL only!');
        }
    }
}
