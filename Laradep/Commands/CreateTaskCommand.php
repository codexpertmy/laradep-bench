<?php

namespace Laradep\Commands;

use Laradep\HasConfig;
use Laradep\HasStub;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTaskCommand extends Command
{
    use HasStub, HasConfig;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('laradep:create_task')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the task.')
            ->setDescription('Create a new task.')
            ->setHelp('This command allows you to create task by using command line interface.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $taskName = $input->getArgument('name') . 'Task';
        $content = str_replace('{{TaskName}}', $taskName, $this->getStub('task.plain'));
        $taskPath = base_path('Laradep/Tasks/');

        file_put_contents($taskPath . $taskName . '.php', $content);

        $output->write(
            sprintf('create task %s',
                $taskPath . $taskName . '.php'
            )
        );
    }

    protected function stubPath()
    {
        return base_path('assets/laradep');
    }

}
