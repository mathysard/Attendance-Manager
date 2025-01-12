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
use App\Entity\Classroom;

#[AsCommand(
    name: 'CreateClassroom',
    description: 'Creates classrooms for the attendances lists.',
)]
class CreateClassroomCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
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
        foreach(['1AI01', '1AI02', '1AI03', '1AI04'] as $classroom) {
            $classroomEntity = new Classroom();

            $classroomEntity->setName($classroom);

            $this->entityManager->persist($classroomEntity);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}
