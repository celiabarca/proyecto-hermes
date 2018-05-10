<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180509182114 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE valoracionusuario (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, usuario_valorado_id INT DEFAULT NULL, valoracion DOUBLE PRECISION NOT NULL, INDEX IDX_34EDE6FCDB38439E (usuario_id), INDEX IDX_34EDE6FCE62A433C (usuario_valorado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE valoracionusuario ADD CONSTRAINT FK_34EDE6FCDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valoracionusuario ADD CONSTRAINT FK_34EDE6FCE62A433C FOREIGN KEY (usuario_valorado_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE proyectos_autores');
        $this->addSql('DROP TABLE valoracion_usuario');
        $this->addSql('ALTER TABLE project ADD autor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE14D45BBE FOREIGN KEY (autor_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE14D45BBE ON project (autor_id)');
        $this->addSql('ALTER TABLE user ADD empresa VARCHAR(30) DEFAULT NULL, ADD sector VARCHAR(30) DEFAULT NULL, ADD rol VARCHAR(20) NOT NULL, ADD img VARCHAR(255) NOT NULL, CHANGE telefono telefono VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE proyectos_autores (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5FF7ADAF166D1F9C (project_id), INDEX IDX_5FF7ADAFA76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valoracion_usuario (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, usuario_valorado_id INT DEFAULT NULL, valoracion DOUBLE PRECISION NOT NULL, INDEX IDX_F7EA4A08DB38439E (usuario_id), INDEX IDX_F7EA4A08E62A433C (usuario_valorado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proyectos_autores ADD CONSTRAINT FK_5FF7ADAF166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proyectos_autores ADD CONSTRAINT FK_5FF7ADAFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE valoracion_usuario ADD CONSTRAINT FK_F7EA4A08DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valoracion_usuario ADD CONSTRAINT FK_F7EA4A08E62A433C FOREIGN KEY (usuario_valorado_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE valoracionusuario');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE14D45BBE');
        $this->addSql('DROP INDEX IDX_2FB3D0EE14D45BBE ON project');
        $this->addSql('ALTER TABLE project DROP autor_id');
        $this->addSql('ALTER TABLE user DROP empresa, DROP sector, DROP rol, DROP img, CHANGE telefono telefono VARCHAR(15) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
