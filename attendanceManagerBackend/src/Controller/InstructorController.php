<?php

namespace App\Controller;

use App\Entity\Instructor;
use App\Controller\LoginController;
use App\Repository\{AttendanceRepository, InstructorRepository, StudentRepository, CourseRepository, ClassroomRepository};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\RequestStack;
use Error;

#[Route('/instructor')]
class InstructorController extends AbstractController
{
    private $serializer;
    private $request;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoginController $loginController,
        private AttendanceRepository $attendanceRepository,
        private InstructorRepository $instructorRepository,
        private StudentRepository $studentRepository,
        private CourseRepository $courseRepository,
        private ClassroomRepository $classroomRepository,
        protected RequestStack $requestStack
    )
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->request = $this->requestStack->getCurrentRequest();
    }

    #[Route('/create', name: 'instructor_create', methods: ['GET', 'POST'])]
    public function create()
    {
        $crits = $this->request->request->all();

        $instructor = new Instructor();

        $instructor->setFirstName($crits['first_name']);
        $instructor->setLastName($crits['last_name']);
        $instructor->setEmail($crits['email']);
        $instructor->setPassword(password_hash($crits['password'], PASSWORD_DEFAULT));

        if($this->loginController->isAdmin()) {
            $this->entityManager->persist($instructor);
            $this->entityManager->flush();
        } else {
            throw new Error("You do not have the permission to create the instructor " . $id . ".");
        }

        return new JsonResponse([
            'message' => 'Instructor created successfully.',
            'instructor' => $this->serializer->serialize($instructor, 'json')
        ]);
    }

    #[Route('/update', name: 'instructor_update', methods: ['GET', 'POST'])]
    public function update()
    {
        $crits = $this->request->request->all();
        $id = $this->request->query->get('instructorId');

        if(!$id) {
            throw new Error("The instructor id was not provided.");
        }

        $instructor = $this->instructorRepository->find($id);

        if(!$instructor) {
            throw new Error("Instructor " . $id . " was not found.");
        }

        $instructor->setFirstName($crits['first_name']);
        $instructor->setLastName($crits['last_name']);
        $instructor->setEmail($crits['email']);
        $instructor->setPassword(password_hash($crits['password'], PASSWORD_DEFAULT));

        if($this->loginController->isAdmin()) {
            $this->entityManager->persist($instructor);
            $this->entityManager->flush();
        } else {
            throw new Error("You do not have the permission to update the instructor " . $id . ".");
        }

        return new JsonResponse([
            'message' => 'Instructor ' . $id . ' updated successfully.',
            'instructor' => $this->serializer->serialize($instructor, 'json')
        ]);
    }

    #[Route('/retrieve', name: 'instructor_retrieve', methods: ['GET', 'POST'])]
    public function retrieve()
    {
        $id = $this->request->query->get('id');

        if(!$id) {
            throw new Error('The id was not provided.');
        }

        $instructor = $this->instructorRepository->find($id);

        if(!$instructor) {
            throw new Error('Instructor ' . $id . ' not found.');
        }

        return new JsonResponse([
            'message' => 'Instructor retrieved successfully.',
            'instructor' => $this->serializer->serialize($instructor, 'json')
        ]);
    }

    #[Route('/getClassrooms', name: 'app_instructor', methods: ['GET', 'POST'])]
    public function getClassrooms()
    {
        $id = $this->request->query->get('instructorId');

        $instructor = $this->instructorRepository->find($id);

        if(!$instructor) {
            throw new Error('Instructor ' . $id . ' was not found.');
        }

        $classrooms = $this->instructorClassroomRepository->findBy(['instructor' => $instructor]);

        if(!$classrooms) {
            throw new Error('Classrooms with the instructor id ' . $id . ' were not found.');
        }

        return new JsonResponse([
            'message' => 'Classrooms retrieved successfully.',
            'classrooms' => $this->serializer->serialize($classrooms, 'json')
        ]);
    }
}
