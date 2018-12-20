<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'user:create';

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Crete new user')
            ->addArgument('username', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $password)
        );
        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        $io->success(sprintf('Created user: %s', $username));
    }
}
