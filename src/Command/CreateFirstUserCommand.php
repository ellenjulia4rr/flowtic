<?php

namespace App\Command;

use App\Service\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:first-user')]
class CreateFirstUserCommand extends Command
{
    private UserService $service;

    public function __construct(
        UserService $service
    )
    {
        parent::__construct();
        $this->service = $service;

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->service->firstUser();

        return Command::SUCCESS;
    }
}