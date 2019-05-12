<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180503210523 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Team - allow empty Scientific Organization';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_teams
          CHANGE scientific_organization scientific_organization VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE registration_teams
          DROP INDEX UNIQ_196882B0B03A8386,
          ADD INDEX IDX_196882B0B03A8386 (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_teams
          DROP INDEX IDX_196882B0B03A8386,
          ADD UNIQUE INDEX UNIQ_196882B0B03A8386 (created_by_id)');
        $this->addSql('ALTER TABLE registration_teams
          CHANGE scientific_organization scientific_organization VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
