<?php

namespace App\Controller;

use App\Entity\Instructor;
use App\Repository\{AttendanceRepository, AdministratorRepository, InstructorRepository, StudentRepository, CourseRepository, ClassroomRepository};
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

class LoginController extends AbstractController
{
    private $serializer;
    private $request;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private AdministratorRepository $administratorRepository,
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

    #[Route('/authenticate', name: 'authenticate', methods: ['GET', 'POST'])]
    public function authenticate()
    {
        $crits = $this->request->query->all();
        
        // Necessary authentication crits = email & password
        if($admin = $this->administratorRepository->findOneBy(['email' => $crits['email']])) {
            if(password_verify($crits['password'], $admin->getPassword()) == 1) {
                $adminData = [
                    'id' => $admin->getId(),
                    'firstName' => $admin->getFirstName(),
                    'lastName' => $admin->getLastName(),
                    'email' => $admin->getEmail()
                ];

                return new JsonResponse([
                    'message' => 'Administrator retrieved successfully.',
                    'isAdmin' => true,
                    'admin' => $this->serializer->serialize($adminData, 'json')
                ]);
            } else {
                return new JsonResponse([
                    'error' => 'Password is incorrect.'
                ]);
            }
        } elseif($instructor = $this->instructorRepository->findOneBy(['email' => $crits['email']])) {
            if(password_verify($crits['password'], $instructor->getPassword()) == 1) {
                $instructorData = [
                    'id' => $instructor->getId(),
                    'firstName' => $instructor->getFirstName(),
                    'lastName' => $instructor->getLastName(),
                    'email' => $instructor->getEmail()
                ];

                return new JsonResponse([
                    'message' => 'Instructor retrieved successfully.',
                    'isAdmin' => false,
                    'instructor' => $this->serializer->serialize($instructorData, 'json')
                ]);
            } else {
                return new JsonResponse([
                    'error' => 'Password is incorrect.'
                ]);
            }
        } else {
            throw new Error("User of e-mail " . $crits['email'] . " was not found.");
        }
    }
}
