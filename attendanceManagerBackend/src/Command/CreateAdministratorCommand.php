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
use App\Entity\Administrator;

#[AsCommand(
    name: 'CreateAdministrator',
    description: 'Add a short description for your command',
)]
class CreateAdministratorCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
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
        $administrator = new Administrator();

        $administrator->setFirstName("Toto");
        $administrator->setLastName("Tata");
        $administrator->setEmail("tototata@attendanceManager.support.be");
        $administrator->setPassword(password_hash("tototata", PASSWORD_DEFAULT));

        $this->entityManager->persist($administrator);
        $this->entityManager->flush();

        /*
            Étant donné que c'est un simple examen, je me permets de mettre les infos en clair ici afin qu'elles puissent être modifiées
            lors du test de l'application.
        */
        
        return Command::SUCCESS;
    }
}
