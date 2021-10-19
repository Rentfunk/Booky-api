<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019125736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(200) NOT NULL, authors VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_grade (book_id INT NOT NULL, grade_id INT NOT NULL, INDEX IDX_5798BB4D16A2B381 (book_id), INDEX IDX_5798BB4DFE19A1A8 (grade_id), PRIMARY KEY(book_id, grade_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_has_book (id INT AUTO_INCREMENT NOT NULL, classroom_id INT NOT NULL, book_id INT NOT NULL, school_year_id INT NOT NULL, books_owned INT NOT NULL, books_returned INT NOT NULL, INDEX IDX_2277B33E6278D5A8 (classroom_id), INDEX IDX_2277B33E16A2B381 (book_id), INDEX IDX_2277B33ED2EECC3F (school_year_id), UNIQUE INDEX UNIQ_2277B33E6278D5A816A2B381 (classroom_id, book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, grade_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_497D309DFE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_595AAE345E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, code VARCHAR(255) DEFAULT NULL, isbn VARCHAR(255) DEFAULT NULL, registry_number VARCHAR(255) NOT NULL, billing_number VARCHAR(255) DEFAULT NULL, book_quantity INT NOT NULL, price_per_book DOUBLE PRECISION NOT NULL, ordered_at DATETIME NOT NULL, discarded_quantity INT DEFAULT NULL, publication_year INT DEFAULT NULL, INDEX IDX_F529939816A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_tag (order_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_40D2F8E38D9F6D38 (order_id), INDEX IDX_40D2F8E3BAD26311 (tag_id), PRIMARY KEY(order_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_year (id INT AUTO_INCREMENT NOT NULL, year VARCHAR(255) NOT NULL, is_current TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_has_book (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, book_id INT DEFAULT NULL, school_year_id INT NOT NULL, books_owned INT NOT NULL, books_returned INT NOT NULL, INDEX IDX_97AFCBE541807E1D (teacher_id), INDEX IDX_97AFCBE516A2B381 (book_id), INDEX IDX_97AFCBE5D2EECC3F (school_year_id), UNIQUE INDEX UNIQ_97AFCBE541807E1D16A2B381 (teacher_id, book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_grade ADD CONSTRAINT FK_5798BB4D16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_grade ADD CONSTRAINT FK_5798BB4DFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE class_has_book ADD CONSTRAINT FK_2277B33E6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE class_has_book ADD CONSTRAINT FK_2277B33E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE class_has_book ADD CONSTRAINT FK_2277B33ED2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309DFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE order_tag ADD CONSTRAINT FK_40D2F8E38D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_tag ADD CONSTRAINT FK_40D2F8E3BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_has_book ADD CONSTRAINT FK_97AFCBE541807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE teacher_has_book ADD CONSTRAINT FK_97AFCBE516A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE teacher_has_book ADD CONSTRAINT FK_97AFCBE5D2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_grade DROP FOREIGN KEY FK_5798BB4D16A2B381');
        $this->addSql('ALTER TABLE class_has_book DROP FOREIGN KEY FK_2277B33E16A2B381');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939816A2B381');
        $this->addSql('ALTER TABLE teacher_has_book DROP FOREIGN KEY FK_97AFCBE516A2B381');
        $this->addSql('ALTER TABLE class_has_book DROP FOREIGN KEY FK_2277B33E6278D5A8');
        $this->addSql('ALTER TABLE book_grade DROP FOREIGN KEY FK_5798BB4DFE19A1A8');
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309DFE19A1A8');
        $this->addSql('ALTER TABLE order_tag DROP FOREIGN KEY FK_40D2F8E38D9F6D38');
        $this->addSql('ALTER TABLE class_has_book DROP FOREIGN KEY FK_2277B33ED2EECC3F');
        $this->addSql('ALTER TABLE teacher_has_book DROP FOREIGN KEY FK_97AFCBE5D2EECC3F');
        $this->addSql('ALTER TABLE order_tag DROP FOREIGN KEY FK_40D2F8E3BAD26311');
        $this->addSql('ALTER TABLE teacher_has_book DROP FOREIGN KEY FK_97AFCBE541807E1D');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_grade');
        $this->addSql('DROP TABLE class_has_book');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_tag');
        $this->addSql('DROP TABLE school_year');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE teacher_has_book');
    }
}
