<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321101531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_produit (order_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_DFDF456C8D9F6D38 (order_id), INDEX IDX_DFDF456CF347EFB (produit_id), PRIMARY KEY(order_id, produit_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_panier (order_id INT NOT NULL, panier_id INT NOT NULL, INDEX IDX_E7431D278D9F6D38 (order_id), INDEX IDX_E7431D27F77D927C (panier_id), PRIMARY KEY(order_id, panier_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456C8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_panier ADD CONSTRAINT FK_E7431D278D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_panier ADD CONSTRAINT FK_E7431D27F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCD71E064B FOREIGN KEY (id_article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456C8D9F6D38');
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456CF347EFB');
        $this->addSql('ALTER TABLE order_panier DROP FOREIGN KEY FK_E7431D278D9F6D38');
        $this->addSql('ALTER TABLE order_panier DROP FOREIGN KEY FK_E7431D27F77D927C');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_produit');
        $this->addSql('DROP TABLE order_panier');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCD71E064B');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC79F37AE5');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
    }
}
