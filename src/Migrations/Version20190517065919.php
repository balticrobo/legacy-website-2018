<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190517065919 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events
            ADD conference_schedule_id INT DEFAULT NULL
            AFTER schedule_id');
        $this->addSql('ALTER TABLE events
            ADD CONSTRAINT FK_5387574A1FFEF09
            FOREIGN KEY (conference_schedule_id)
            REFERENCES storage_files (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5387574A1FFEF09
            ON events (conference_schedule_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A1FFEF09');
        $this->addSql('DROP INDEX UNIQ_5387574A1FFEF09 ON events');
        $this->addSql('ALTER TABLE events DROP conference_schedule_id');
    }
}
