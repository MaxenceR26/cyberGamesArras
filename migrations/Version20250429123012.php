<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429123012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historique_maintenance (id INT AUTO_INCREMENT NOT NULL, machine_id INT NOT NULL, user_id INT NOT NULL, heure_maintenance DATETIME NOT NULL, INDEX IDX_F62AF68FF6B75B26 (machine_id), INDEX IDX_F62AF68FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique_maintenance ADD CONSTRAINT FK_F62AF68FF6B75B26 FOREIGN KEY (machine_id) REFERENCES machines (id)');
        $this->addSql('ALTER TABLE historique_maintenance ADD CONSTRAINT FK_F62AF68FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY token_ibfk_1');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY token_ibfk_2');
        $this->addSql('DROP INDEX machine_id ON token');
        $this->addSql('DROP INDEX id_user ON token');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY transactions_ibfk_1');
        $this->addSql('DROP INDEX user_id ON transactions');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique_maintenance DROP FOREIGN KEY FK_F62AF68FF6B75B26');
        $this->addSql('ALTER TABLE historique_maintenance DROP FOREIGN KEY FK_F62AF68FA76ED395');
        $this->addSql('DROP TABLE historique_maintenance');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT transactions_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX user_id ON transactions (user_id)');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT token_ibfk_1 FOREIGN KEY (machine_id) REFERENCES machines (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT token_ibfk_2 FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX machine_id ON token (machine_id)');
        $this->addSql('CREATE INDEX id_user ON token (id_user)');
    }
}
