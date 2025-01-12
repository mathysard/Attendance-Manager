<?php

namespace App\Entity;

use App\Repository\AttendanceStudentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceStudentsRepository::class)]
class AttendanceStudents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attendanceStudents')]
    private ?Attendance $attendance = null;

    #[ORM\ManyToOne(inversedBy: 'attendanceStudents')]
    private ?Student $student = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $studentState = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttendance(): ?Attendance
    {
        return $this->attendance;
    }

    public function setAttendance(?Attendance $attendance): static
    {
        $this->attendance = $attendance;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getStudentState(): ?string
    {
        return $this->studentState;
    }

    public function setStudentState(?string $studentState): static
    {
        $this->studentState = $studentState;

        return $this;
    }
}
