<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190517212427 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE volunteers ADD given_shirts JSON NOT NULL AFTER shirt_type');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE volunteers DROP given_shirts');
    }
}
