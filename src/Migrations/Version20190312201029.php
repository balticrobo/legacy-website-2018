<?php

declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20190312201029 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Hackathon Team Member - add email and phone number to each member of Team';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_members_hackathon
          ADD phone_number CHAR(9) NOT NULL,
          ADD email VARCHAR(80) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_members_hackathon
          DROP phone_number,
          DROP email');
    }
}
