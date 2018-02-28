<?php

namespace Laradep\Commands;

use Laradep\HasConfig;
use Laradep\HasStub;
use Laradep\Tasks\LoggingTask;
use Laradep\Tasks\NginxVhostTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateVhostCommand extends Command
{
    use HasStub, HasConfig;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('laradep:create_vhost')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the application.')
            ->setDescription('Create a vhost for application.')
            ->setHelp('This command allows you to create vhost by using command line interface.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logging = new NginxVhostTask($input->getArgument('name'));
        $logging->run();
    }

}
