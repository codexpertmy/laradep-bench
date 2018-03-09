<?php

namespace Laradep\Commands;

use Laradep\Concerns\HasConfig;
use Laradep\Concerns\HasStub;
use Laradep\Tasks\CloneProjectRepositoryTask;
use Laradep\Tasks\LoggingTask;
use Laradep\Tasks\NginxVhostTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HttpVhostLaravelSetupCommand extends Command
{
    use HasStub, HasConfig;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('laradep:deploy')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the application.')
            ->addArgument('repository', InputArgument::REQUIRED, 'The repository of the application.')
            ->setDescription('Deploy laravel application with http minimal configuration using nginx.')
            ->setHelp('This command allows you to deploy laravel project by using command line interface.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //prioritize on clone project first
        $app = $input->getArgument('name');
        $repositoryOrigin = $input->getArgument('repository');

        $task = new CloneProjectRepositoryTask($app);
        $task->setupRepository($repositoryOrigin);
        $output->writeln($task->run());

        //create logging
        $logging = new LoggingTask($app);
        $logging->run();
        $output->write('logging are created.');

        //create vhost
        $logging = new NginxVhostTask($app);
        $logging->run();

        //after this process
        //laravel application should be accessible within domain name assigned while create app before
    }

}
