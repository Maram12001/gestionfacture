<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428094823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, raison_sociale VARCHAR(50) NOT NULL, matricule_fiscale INT NOT NULL, fax INT NOT NULL, adresse VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_client (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, date_echeance DATETIME NOT NULL, date_emission DATETIME NOT NULL, etat_comptable TINYINT(1) NOT NULL, INDEX IDX_92D316F219EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_fournisseur (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT NOT NULL, date_echaence DATETIME NOT NULL, date_emission DATETIME NOT NULL, etat_comptable TINYINT(1) NOT NULL, INDEX IDX_311911C4670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, raison_sociale VARCHAR(50) NOT NULL, matricule_fiscale INT NOT NULL, fax INT NOT NULL, adresse VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_produit_client (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, facture_client_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, remise DOUBLE PRECISION NOT NULL, INDEX IDX_AA8FDA0F347EFB (produit_id), INDEX IDX_AA8FDA0D34354A5 (facture_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_produit_fournisseur (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, locale VARCHAR(10) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workflow_paiements (id INT AUTO_INCREMENT NOT NULL, facture_fournisseur_id INT NOT NULL, service_id INT NOT NULL, date_reception DATETIME NOT NULL, date_emission DATETIME NOT NULL, statut VARCHAR(50) NOT NULL, INDEX IDX_1C19B497C755704D (facture_fournisseur_id), INDEX IDX_1C19B497ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workflowpaiement (id INT AUTO_INCREMENT NOT NULL, facture_fournisseur_id INT NOT NULL, date_emission DATETIME NOT NULL, status INT DEFAULT NULL, INDEX IDX_C7D80DD3C755704D (facture_fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture_client ADD CONSTRAINT FK_92D316F219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE facture_fournisseur ADD CONSTRAINT FK_311911C4670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE ligne_produit_client ADD CONSTRAINT FK_AA8FDA0F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_produit_client ADD CONSTRAINT FK_AA8FDA0D34354A5 FOREIGN KEY (facture_client_id) REFERENCES facture_client (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE workflow_paiements ADD CONSTRAINT FK_1C19B497C755704D FOREIGN KEY (facture_fournisseur_id) REFERENCES facture_fournisseur (id)');
        $this->addSql('ALTER TABLE workflow_paiements ADD CONSTRAINT FK_1C19B497ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE workflowpaiement ADD CONSTRAINT FK_C7D80DD3C755704D FOREIGN KEY (facture_fournisseur_id) REFERENCES facture_fournisseur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture_client DROP FOREIGN KEY FK_92D316F219EB6921');
        $this->addSql('ALTER TABLE facture_fournisseur DROP FOREIGN KEY FK_311911C4670C757F');
        $this->addSql('ALTER TABLE ligne_produit_client DROP FOREIGN KEY FK_AA8FDA0F347EFB');
        $this->addSql('ALTER TABLE ligne_produit_client DROP FOREIGN KEY FK_AA8FDA0D34354A5');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE workflow_paiements DROP FOREIGN KEY FK_1C19B497C755704D');
        $this->addSql('ALTER TABLE workflow_paiements DROP FOREIGN KEY FK_1C19B497ED5CA9E6');
        $this->addSql('ALTER TABLE workflowpaiement DROP FOREIGN KEY FK_C7D80DD3C755704D');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE facture_client');
        $this->addSql('DROP TABLE facture_fournisseur');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE ligne_produit_client');
        $this->addSql('DROP TABLE ligne_produit_fournisseur');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE workflow_paiements');
        $this->addSql('DROP TABLE workflowpaiement');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
