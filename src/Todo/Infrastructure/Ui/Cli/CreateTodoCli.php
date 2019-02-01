<?php

declare(strict_types=1);

namespace Todo\Infrastructure\Ui\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Todo\Application\Todo\Create\TodoCreator;

final class CreateTodoCli extends Command
{
    /** @var TodoCreator */
    private $todoCreator;

    public function __construct(TodoCreator $todoCreator)
    {
        $this->todoCreator = $todoCreator;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this
            ->setName('todo:create')
            ->setDescription('Creates a todo.')
            ->addArgument('description', InputArgument::REQUIRED, 'The todo description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating Todo');
        $this->todoCreator->create($input->getArgument('description'));
        $output->write('Todo created');
    }
}