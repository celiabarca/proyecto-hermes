<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180508155854 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, proyecto_id INT DEFAULT NULL, autor_id INT DEFAULT NULL, contenido VARCHAR(255) NOT NULL, fechacreacion DATETIME NOT NULL, INDEX IDX_9474526CF625D1BA (proyecto_id), INDEX IDX_9474526C14D45BBE (autor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donacion (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, proyecto_id INT DEFAULT NULL, cantidad DOUBLE PRECISION NOT NULL, fecha_donacion DATETIME NOT NULL, INDEX IDX_FC2BEE86DB38439E (usuario_id), INDEX IDX_FC2BEE86F625D1BA (proyecto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(60) NOT NULL, descripcion VARCHAR(250) NOT NULL, contenido VARCHAR(2048) NOT NULL, fecha_creacion DATETIME NOT NULL, destacado TINYINT(1) NOT NULL, meta DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proyectos_autores (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5FF7ADAF166D1F9C (project_id), INDEX IDX_5FF7ADAFA76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proyectos_patrocinadores (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D702F51E166D1F9C (project_id), INDEX IDX_D702F51EA76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proyectos_colaboradores (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F03A07B7166D1F9C (project_id), INDEX IDX_F03A07B7A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_tag (project_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_91F26D60166D1F9C (project_id), INDEX IDX_91F26D60BAD26311 (tag_id), PRIMARY KEY(project_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seguimiento (id INT AUTO_INCREMENT NOT NULL, proyecto_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, fecha DATETIME NOT NULL, situacion VARCHAR(60) NOT NULL, INDEX IDX_1B2181DF625D1BA (proyecto_id), INDEX IDX_1B2181DDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(30) NOT NULL, telefono VARCHAR(15) NOT NULL, password VARCHAR(60) NOT NULL, destacado TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valoracion (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, proyecto_id INT DEFAULT NULL, puntuacion DOUBLE PRECISION NOT NULL, INDEX IDX_6D3DE0F4DB38439E (usuario_id), INDEX IDX_6D3DE0F4F625D1BA (proyecto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valoracion_usuario (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, usuario_valorado_id INT DEFAULT NULL, valoracion DOUBLE PRECISION NOT NULL, INDEX IDX_F7EA4A08DB38439E (usuario_id), INDEX IDX_F7EA4A08E62A433C (usuario_valorado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF625D1BA FOREIGN KEY (proyecto_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C14D45BBE FOREIGN KEY (autor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE donacion ADD CONSTRAINT FK_FC2BEE86DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE donacion ADD CONSTRAINT FK_FC2BEE86F625D1BA FOREIGN KEY (proyecto_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE proyectos_autores ADD CONSTRAINT FK_5FF7ADAF166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proyectos_autores ADD CONSTRAINT FK_5FF7ADAFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proyectos_patrocinadores ADD CONSTRAINT FK_D702F51E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proyectos_patrocinadores ADD CONSTRAINT FK_D702F51EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proyectos_colaboradores ADD CONSTRAINT FK_F03A07B7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proyectos_colaboradores ADD CONSTRAINT FK_F03A07B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_tag ADD CONSTRAINT FK_91F26D60166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_tag ADD CONSTRAINT FK_91F26D60BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seguimiento ADD CONSTRAINT FK_1B2181DF625D1BA FOREIGN KEY (proyecto_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE seguimiento ADD CONSTRAINT FK_1B2181DDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valoracion ADD CONSTRAINT FK_6D3DE0F4DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valoracion ADD CONSTRAINT FK_6D3DE0F4F625D1BA FOREIGN KEY (proyecto_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE valoracion_usuario ADD CONSTRAINT FK_F7EA4A08DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valoracion_usuario ADD CONSTRAINT FK_F7EA4A08E62A433C FOREIGN KEY (usuario_valorado_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF625D1BA');
        $this->addSql('ALTER TABLE donacion DROP FOREIGN KEY FK_FC2BEE86F625D1BA');
        $this->addSql('ALTER TABLE proyectos_autores DROP FOREIGN KEY FK_5FF7ADAF166D1F9C');
        $this->addSql('ALTER TABLE proyectos_patrocinadores DROP FOREIGN KEY FK_D702F51E166D1F9C');
        $this->addSql('ALTER TABLE proyectos_colaboradores DROP FOREIGN KEY FK_F03A07B7166D1F9C');
        $this->addSql('ALTER TABLE project_tag DROP FOREIGN KEY FK_91F26D60166D1F9C');
        $this->addSql('ALTER TABLE seguimiento DROP FOREIGN KEY FK_1B2181DF625D1BA');
        $this->addSql('ALTER TABLE valoracion DROP FOREIGN KEY FK_6D3DE0F4F625D1BA');
        $this->addSql('ALTER TABLE project_tag DROP FOREIGN KEY FK_91F26D60BAD26311');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C14D45BBE');
        $this->addSql('ALTER TABLE donacion DROP FOREIGN KEY FK_FC2BEE86DB38439E');
        $this->addSql('ALTER TABLE proyectos_autores DROP FOREIGN KEY FK_5FF7ADAFA76ED395');
        $this->addSql('ALTER TABLE proyectos_patrocinadores DROP FOREIGN KEY FK_D702F51EA76ED395');
        $this->addSql('ALTER TABLE proyectos_colaboradores DROP FOREIGN KEY FK_F03A07B7A76ED395');
        $this->addSql('ALTER TABLE seguimiento DROP FOREIGN KEY FK_1B2181DDB38439E');
        $this->addSql('ALTER TABLE valoracion DROP FOREIGN KEY FK_6D3DE0F4DB38439E');
        $this->addSql('ALTER TABLE valoracion_usuario DROP FOREIGN KEY FK_F7EA4A08DB38439E');
        $this->addSql('ALTER TABLE valoracion_usuario DROP FOREIGN KEY FK_F7EA4A08E62A433C');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE donacion');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE proyectos_autores');
        $this->addSql('DROP TABLE proyectos_patrocinadores');
        $this->addSql('DROP TABLE proyectos_colaboradores');
        $this->addSql('DROP TABLE project_tag');
        $this->addSql('DROP TABLE seguimiento');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE valoracion');
        $this->addSql('DROP TABLE valoracion_usuario');
    }
}
