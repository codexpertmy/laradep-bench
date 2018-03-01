<?php

namespace Laradep\Commands;

use Laradep\Concerns\HasConfig;
use Laradep\Concerns\HasStub;
use Laradep\Tasks\CloneProjectRepositoryTask;
use Laradep\Tasks\CreateDatabaseProjectTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDatabaseMysqlCommand extends Command
{
    use HasStub, HasConfig;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('laradep:create_database')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the task.')
            ->setDescription('Setup database for current project.')
            ->setHelp('This command allows you to setup project database from repository by using command line interface.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $input->getArgument('name');

        $task = new CreateDatabaseProjectTask($app);
        $output->writeln($task->run());
    }

    protected function stubPath()
    {
        return base_path('assets/laradep');
    }

}
