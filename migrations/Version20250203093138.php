<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203093138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions ADD user_id INT NOT NULL, ADD amount_credit INT NOT NULL, ADD total_price INT NOT NULL, ADD method VARCHAR(255) NOT NULL, ADD state VARCHAR(255) NOT NULL, ADD date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD reference VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP user_id, DROP amount_credit, DROP total_price, DROP method, DROP state, DROP date, DROP reference');
    }
}
