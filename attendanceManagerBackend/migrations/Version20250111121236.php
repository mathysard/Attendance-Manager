<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111121236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendance (id INT AUTO_INCREMENT NOT NULL, instructor_id INT DEFAULT NULL, classroom_id INT DEFAULT NULL, course_id INT DEFAULT NULL, hour VARCHAR(255) DEFAULT NULL, day VARCHAR(255) DEFAULT NULL, INDEX IDX_6DE30D918C4FC193 (instructor_id), INDEX IDX_6DE30D916278D5A8 (classroom_id), INDEX IDX_6DE30D91591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attendance_students (id INT AUTO_INCREMENT NOT NULL, attendance_id INT DEFAULT NULL, student_id INT DEFAULT NULL, student_state VARCHAR(255) DEFAULT NULL, INDEX IDX_4A602B70163DDA15 (attendance_id), INDEX IDX_4A602B70CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D918C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D916278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE attendance_students ADD CONSTRAINT FK_4A602B70163DDA15 FOREIGN KEY (attendance_id) REFERENCES attendance (id)');
        $this->addSql('ALTER TABLE attendance_students ADD CONSTRAINT FK_4A602B70CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D918C4FC193');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D916278D5A8');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91591CC992');
        $this->addSql('ALTER TABLE attendance_students DROP FOREIGN KEY FK_4A602B70163DDA15');
        $this->addSql('ALTER TABLE attendance_students DROP FOREIGN KEY FK_4A602B70CB944F1A');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE attendance_students');
    }
}
