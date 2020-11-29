<?php

namespace App\Command;
//namespace Symfony\Bundle\FrameworkBundle\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Faker\Factory;
use Symfony\Component\Console\Helper\Table;
use Symfony\Bundle\FrameworkBundle\Console;

class UserListCommand extends Command
{
    protected static $defaultName = 'user:list';
    protected $faker;
    private $arr;

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('cases', InputArgument::REQUIRED, 'liczba wygenerowanych danych')
            ->addOption('GenerateData', '-r', InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('cases');
        $this->faker = Factory::create();

        if ($arg1) {

            for($i=0; $i<$arg1; $i++ ){ //generowanie tablicy na podstawie ilości przypadków zadanej przez użytkownika
                $this->arr[] = [$this->faker->firstName, $this->faker->lastName, $this->faker->address];
            }

            $table = new Table($output); //tworzenie tabeli
            $table
                ->setHeaders(['First Name', 'Last Name', 'Address'])
                ->setRows($this->arr);
            $table->render();

            $_GET['data'] = json_encode($this->arr); //tworzenie JSON'a i dodawania go do "szufladki"

            if( php_sapi_name() == 'cli' ){ //sprawdzenie czy zostałą użyta konsola, jeśli tak to wypisze JSON'a
                echo $_GET['data'];
            }
        }

        $io->success('Zakończono generowanie danych');

        return Command::SUCCESS;
    }

}
