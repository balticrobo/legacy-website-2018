<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180508185144 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D77EAC75E237E06296CD8AE ON registration_constructions (name, team_id)');
    }

    public function down(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('DROP INDEX UNIQ_2D77EAC75E237E06296CD8AE ON registration_constructions');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
