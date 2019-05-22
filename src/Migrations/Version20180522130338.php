<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180522130338 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Event - add Schedule selected from File';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events
          ADD schedule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE events
          ADD CONSTRAINT FK_5387574AA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES storage_files (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5387574AA40BC2D5 ON events (schedule_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AA40BC2D5');
        $this->addSql('DROP INDEX UNIQ_5387574AA40BC2D5 ON events');
        $this->addSql('ALTER TABLE events DROP schedule_id');
    }
}
