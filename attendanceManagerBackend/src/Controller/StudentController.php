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

class StudentController extends AbstractController
{
    private $serializer;
    private $request;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoginController $loginController,
        private AttendanceRepository $attendanceRepository,
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

    #[Route('/getStudents', name: 'app_get_students')]
    public function getStudents()
    {
        $students = $this->studentRepository->findAll();

        return new JsonResponse([
            'message' => 'Students retrieved successfully',
            'students' => $this->serializer->serialize($students, 'json')
        ]);
    }
}
