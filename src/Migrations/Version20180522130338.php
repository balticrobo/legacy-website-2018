<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180522130338 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events
          ADD schedule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE events
          ADD CONSTRAINT FK_5387574AA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES storage_files (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5387574AA40BC2D5 ON events (schedule_id)');
    }

    public function down(Schema $schema)
    {
        $this->checkDatabaseType();
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AA40BC2D5');
        $this->addSql('DROP INDEX UNIQ_5387574AA40BC2D5 ON events');
        $this->addSql('ALTER TABLE events DROP schedule_id');
    }

    private function checkDatabaseType(): void
    {
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            throw new AbortMigrationException('MySQL only!');
        }
    }
}
