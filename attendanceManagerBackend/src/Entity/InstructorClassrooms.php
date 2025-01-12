<?php

namespace App\Entity;

use App\Repository\InstructorClassroomsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructorClassroomsRepository::class)]
class InstructorClassrooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'instructorClassrooms')]
    private ?Instructor $instructor = null;

    #[ORM\ManyToOne(inversedBy: 'instructorClassrooms')]
    private ?Classroom $classroom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): static
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): static
    {
        $this->classroom = $classroom;

        return $this;
    }
}
