<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Service\UserManager;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:create-user')]
class CreateUserCommand extends Command
{
    /* public function __construct( private UserPasswordHasherInterface $passwordHasher,){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // configure an argument
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
            // ...
        ;
    }

    // ...
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);
        $pas = $input->getArgument('username');
         
        // retrieve the argument value using getArgument()
        $output->writeln('Username: '.$input->getArgument('username'));
        $output->writeln($passwordHasher -> hashPassword($pas));
        return Command::SUCCESS;
    } */
}