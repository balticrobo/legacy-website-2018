<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180425154134 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify User - add Token to authorize account';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users 
            ADD token VARCHAR(32) DEFAULT NULL,
            ADD token_requested_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users
            DROP token,
            DROP token_requested_at');
    }
}
