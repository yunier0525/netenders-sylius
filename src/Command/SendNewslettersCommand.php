<?php

namespace App\Command;

use App\Services\SendNewslettersService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class SendNewslettersCommand extends Command
{
    public function __construct(
        private SendNewslettersService $service
    ) {
        parent::__construct();
    }

    // In this function set the name, description and help hint for the command
    protected function configure(): void
    {
        // Use in-build functions to set name, description and help

        $this->setName('send-newsletters')
            ->setDescription('This command send the newsletters to subscribers.')
            ->addArgument('id', InputArgument::REQUIRED, 'Id of newsletter or "all" to send all newsletters.');
    }

    // write the code you want to execute when command runs
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // If you want to write some output
        $newsletterId = $input->getArgument('id');

        if ($this->service->sendNewsletter($newsletterId)) {
            return Command::SUCCESS;
        } else {
            return Command::FAILURE;
        }
    }
}
