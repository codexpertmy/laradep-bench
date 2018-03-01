<?php

namespace Laradep\Commands;

use Laradep\Concerns\HasConfig;
use Laradep\Concerns\HasStub;
use Laradep\Tasks\CloneProjectRepositoryTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateProjectCommand extends Command
{
    use HasStub, HasConfig;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('laradep:clone_project')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the task.')
            ->addArgument('repository', InputArgument::REQUIRED, 'The name of the repository.')
            ->setDescription('Clone  new project.')
            ->setHelp('This command allows you to clone project from repository by using command line interface.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $input->getArgument('name');
        $repositoryOrigin = $input->getArgument('repository');

        $task = new CloneProjectRepositoryTask($app);
        $task->setupRepository($repositoryOrigin);
        $output->writeln($task->run());
    }

    protected function stubPath()
    {
        return base_path('assets/laradep');
    }

}
