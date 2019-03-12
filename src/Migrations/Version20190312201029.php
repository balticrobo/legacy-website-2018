<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190312201029 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE registration_members_hackathon
          ADD phone_number CHAR(9) NOT NULL,
          ADD email VARCHAR(80) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE registration_members_hackathon
          DROP phone_number,
          DROP email');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
