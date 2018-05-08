<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180508150226 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE valoracion_usuario (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, usuario_valorado_id INT DEFAULT NULL, valoracion DOUBLE PRECISION NOT NULL, INDEX IDX_F7EA4A08DB38439E (usuario_id), INDEX IDX_F7EA4A08E62A433C (usuario_valorado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE valoracion_usuario ADD CONSTRAINT FK_F7EA4A08DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valoracion_usuario ADD CONSTRAINT FK_F7EA4A08E62A433C FOREIGN KEY (usuario_valorado_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD contenido VARCHAR(2048) NOT NULL, CHANGE descripcion descripcion VARCHAR(250) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE valoracion_usuario');
        $this->addSql('ALTER TABLE project DROP contenido, CHANGE descripcion descripcion VARCHAR(1024) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
