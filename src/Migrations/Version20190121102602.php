<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190121102602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag_quizz (tag_id INT NOT NULL, quizz_id INT NOT NULL, INDEX IDX_5E9B8E3BBAD26311 (tag_id), INDEX IDX_5E9B8E3BBA934BCD (quizz_id), PRIMARY KEY(tag_id, quizz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_wiki (tag_id INT NOT NULL, wiki_id INT NOT NULL, INDEX IDX_CCC263B0BAD26311 (tag_id), INDEX IDX_CCC263B0AA948DBE (wiki_id), PRIMARY KEY(tag_id, wiki_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tag (user_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E89FD608A76ED395 (user_id), INDEX IDX_E89FD608BAD26311 (tag_id), PRIMARY KEY(user_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_quizz ADD CONSTRAINT FK_5E9B8E3BBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_quizz ADD CONSTRAINT FK_5E9B8E3BBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_wiki ADD CONSTRAINT FK_CCC263B0BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_wiki ADD CONSTRAINT FK_CCC263B0AA948DBE FOREIGN KEY (wiki_id) REFERENCES wiki (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tag ADD CONSTRAINT FK_E89FD608A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tag ADD CONSTRAINT FK_E89FD608BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizz_score ADD user_id INT DEFAULT NULL, ADD quizz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quizz_score ADD CONSTRAINT FK_C8603DAFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quizz_score ADD CONSTRAINT FK_C8603DAFBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('CREATE INDEX IDX_C8603DAFA76ED395 ON quizz_score (user_id)');
        $this->addSql('CREATE INDEX IDX_C8603DAFBA934BCD ON quizz_score (quizz_id)');
        $this->addSql('ALTER TABLE question ADD quizz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EBA934BCD ON question (quizz_id)');
        $this->addSql('ALTER TABLE user ADD role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
        $this->addSql('ALTER TABLE answer ADD question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('ALTER TABLE game_score ADD user_id INT DEFAULT NULL, ADD game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game_score ADD CONSTRAINT FK_AA4EDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_score ADD CONSTRAINT FK_AA4EDEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_AA4EDEA76ED395 ON game_score (user_id)');
        $this->addSql('CREATE INDEX IDX_AA4EDEE48FD905 ON game_score (game_id)');
        $this->addSql('ALTER TABLE game ADD help_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CD3F165E7 ON game (help_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tag_quizz');
        $this->addSql('DROP TABLE tag_wiki');
        $this->addSql('DROP TABLE user_tag');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('DROP INDEX IDX_DADD4A251E27F6BF ON answer');
        $this->addSql('ALTER TABLE answer DROP question_id');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD3F165E7');
        $this->addSql('DROP INDEX UNIQ_232B318CD3F165E7 ON game');
        $this->addSql('ALTER TABLE game DROP help_id');
        $this->addSql('ALTER TABLE game_score DROP FOREIGN KEY FK_AA4EDEA76ED395');
        $this->addSql('ALTER TABLE game_score DROP FOREIGN KEY FK_AA4EDEE48FD905');
        $this->addSql('DROP INDEX IDX_AA4EDEA76ED395 ON game_score');
        $this->addSql('DROP INDEX IDX_AA4EDEE48FD905 ON game_score');
        $this->addSql('ALTER TABLE game_score DROP user_id, DROP game_id');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBA934BCD');
        $this->addSql('DROP INDEX IDX_B6F7494EBA934BCD ON question');
        $this->addSql('ALTER TABLE question DROP quizz_id');
        $this->addSql('ALTER TABLE quizz_score DROP FOREIGN KEY FK_C8603DAFA76ED395');
        $this->addSql('ALTER TABLE quizz_score DROP FOREIGN KEY FK_C8603DAFBA934BCD');
        $this->addSql('DROP INDEX IDX_C8603DAFA76ED395 ON quizz_score');
        $this->addSql('DROP INDEX IDX_C8603DAFBA934BCD ON quizz_score');
        $this->addSql('ALTER TABLE quizz_score DROP user_id, DROP quizz_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON user');
        $this->addSql('ALTER TABLE user DROP role_id');
    }
}
