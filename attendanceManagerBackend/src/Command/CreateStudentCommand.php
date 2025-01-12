<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClassroomRepository;
use App\Entity\Student;
use App\Utils\Students;

#[AsCommand(
    name: 'CreateStudent',
    description: 'Creates students for the attendances lists.',
)]
class CreateStudentCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ClassroomRepository $classroomRepository,
        private Students $students
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $students = $this->students->getStudents();

        foreach($students as $student => $classroom) {
            $classroom = $this->classroomRepository->findOneBy(['name' => $classroom]);

            if(!$classroom) {
                throw new Error("Classroom " . $classroom . " was not found.");
            }

            $studentName = explode(" ", $student);

            $studentEntity = new Student();

            $studentEntity->setFirstName($studentName[0]);
            $studentEntity->setLastName($studentName[1]);
            $studentEntity->setClassroom($classroom);

            $this->entityManager->persist($studentEntity);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}
