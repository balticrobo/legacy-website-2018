<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180516164941 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Event - add second end-date of Registration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events
          ADD registration_stops_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'
          AFTER registration_starts_at');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events DROP registration_stops_at');
    }
}
