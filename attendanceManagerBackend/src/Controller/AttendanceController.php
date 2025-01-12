<?php

namespace App\Controller;

use App\Entity\{Attendance, AttendanceStudents};
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
use App\Utils\{Date, Schedule};
use Error;

#[Route('/attendance')]
class AttendanceController extends AbstractController
{
    private $serializer;
    private $request;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private AttendanceRepository $attendanceRepository,
        private InstructorRepository $instructorRepository,
        private StudentRepository $studentRepository,
        private CourseRepository $courseRepository,
        private ClassroomRepository $classroomRepository,
        protected RequestStack $requestStack,
        private Date $date,
        private Schedule $schedule
    )
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->request = $this->requestStack->getCurrentRequest();
    }

    #[Route('/create', name: 'attendance_create', methods: ['GET', 'POST'])]
    public function create()
    {
        $crits = $this->request->request->all();
        
        $attendance = new Attendance();

        $instructor = $this->instructorRepository->find($crits['instructor_id']);
        $classroom = $this->classroomRepository->find($crits['classroom_id']);
        $course = $this->courseRepository->find($crits['course_id']);

        if(!$instructor) {
            throw new Error('Instructor ' . $crits['instructor_id'] . 'w as not found.');
        }

        if(!$classroom) {
            throw new Error('Classroom ' . $crits['classroom_id'] . ' was not found.');
        }

        if(!$course) {
            throw new Error('Course ' . $crits['course_id'] . ' was not found.');
        }

        if($this->date->getDate() === $crits['day']) {
            if(!isset($crits['all_hours'])) {
                $attendance->setInstructor($instructor);
                $attendance->setClassroom($classroom);
                $attendance->setCourse($course);
                $attendance->setHour($crits['hour']);
                $attendance->setDay($crits['day']);
    
                $this->entityManager->persist($attendance);
                $this->entityManager->flush();
                
            } else {
                $hours = $this->schedule->getSchedule();
    
                foreach($hours as $hour) {
                    $attendance->setInstructor($instructor);
                    $attendance->setClassroom($classroom);
                    $attendance->setCourse($course);
                    $attendance->setHour($hour);
                    $attendance->setDay($crits['day']);
    
                    $this->entityManager->persist($attendance);
                    $this->entityManager->flush();
                    
                }
            }
        } else {
            throw new Error('Based on date, you cannot perform this action.');
        }

        return new JsonResponse([
            'message' => 'Attendance stored successfully.',
            'attendance' => $attendance
        ]);
    }

    #[Route('/update', name: 'attendance_update', methods: ['GET', 'POST'])]
    public function update()
    {
        $crits = $this->request->request->all();
        
        $attendance = $this->attendanceRepository->find($crits['attendance_id']);
        $instructor = $this->instructorRepository->find($crits['instructor_id']);
        $classroom = $this->classroomRepository->find($crits['classroom_id']);
        $course = $this->courseRepository->find($crits['course_id']);

        if(!$attendance) {
            throw new Error('Attendance ' . $crits['attendance_id'] . ' was not found.');
        }

        if(!$instructor) {
            throw new Error('Instructor ' . $crits['instructor_id'] . ' was not found.');
        }

        if(!$classroom) {
            throw new Error('Classroom ' . $crits['classroom_id'] . ' was not found.');
        }

        if(!$course) {
            throw new Error('Course ' . $crits['course_id'] . ' was not found.');
        }

        if($this->date->getDate() === $crits['day']) {
            if(!isset($crits['all_hours'])) {
                $attendance->setInstructor($instructor);
                $attendance->setClassroom($classroom);
                $attendance->setCourse($course);
                $attendance->setHour($crits['hour']);
                $attendance->setDay($crits['day']);
    
                $this->entityManager->persist($attendance);
                $this->entityManager->flush();
            } else {
                $hours = $this->schedule->getSchedule();
    
                foreach($hours as $hour) {
                    $attendance->setInstructor($instructor);
                    $attendance->setClassroom($classroom);
                    $attendance->setCourse($course);
                    $attendance->setHour($hour);
                    $attendance->setDay($crits['day']);
    
                    $this->entityManager->persist($attendance);
                    $this->entityManager->flush();
                }
            }
        } else {
            throw new Error('Based on date, you cannot perform this action.');
        }

        return new JsonResponse([
            'message' => 'Attendance N°' . $attendance->getId() . ' updated successfully.',
            'attendance' => $attendance
        ]);
    }

    #[Route('/retrieve', name: 'attendance_retrieve', methods: ['GET', 'POST'])]
    public function retrieve()
    {
        $id = $this->request->query->get('id');

        if(!$id) {
            throw new Error('The id was not provided.');
        }

        $attendance = $this->attendanceRepository->find($id);
        
        if(!$attendance) {
            throw new Error('Attendance ' . $id . ' was not found.');
        }
        
        $attendanceStudents = $this->attendanceStudentsRepository->findOneBy(['attendance' => $attendance]);

        if(!$attendanceStudents) {
            throw new Error('Attendance students by the attendance id ' . $id . ' were not found.');
        }

        return new JsonResponse([
            'message' => 'Attendance ' . $attendance->getId() . ' retrieved successfully.',
            'attendance' => $attendance
        ]);
    }
}
