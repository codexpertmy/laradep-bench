<?php

namespace Laradep\Commands;

use Laradep\Concerns\HasConfig;
use Laradep\Concerns\HasStub;
use Laradep\Tasks\LoggingTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateLoggingCommand extends Command
{
    use HasStub, HasConfig;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('laradep:create_logging')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the application.')
            ->setDescription('Create a logging for application.')
            ->setHelp('This command allows you to create logging by using command line interface.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logging = new LoggingTask($input->getArgument('name'));
        $logging->run();
        $output->write('logging are created.');
    }

}
