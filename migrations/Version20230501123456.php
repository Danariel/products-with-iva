<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230501123456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert initial values into the Tax table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO tax (value) VALUES (4), (10), (21)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE tax');
    }
}