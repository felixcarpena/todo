<?php

declare(strict_types=1);

namespace Todo\Infrastructure\Ui\Cli;

use Shared\Domain\Bus\Bus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Todo\Application\Todo\Create\TodoCreator;
use Todo\Domain\Todo\Create\CreateTodo;
use Todo\Domain\Todo\Query\TodoById;
use Todo\Domain\Todo\ReadModel\TodoProjection;
use Todo\Domain\Todo\TodoIdGenerator;

final class CreateTodoCli extends Command
{
    /** @var TodoCreator */
    private $todoCreator;
    /** @var Bus */
    private $bus;
    /** @var TodoIdGenerator */
    private $idGenerator;

    public function __construct(TodoIdGenerator $idGenerator, Bus $bus)
    {
        $this->idGenerator = $idGenerator;
        $this->bus = $bus;
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
        $todoId = $this->idGenerator->generate();
        $this->bus->dispatch(new CreateTodo($todoId, $input->getArgument('description')));
        $output->writeln('Todo created');

        $result = $this->bus->dispatch(new TodoById($todoId));
        /** @var TodoProjection $todoProjection */
        $todoProjection = $result->first();
        $output->write("Todo data: {$todoProjection->id()} | '{$todoProjection->description()}'");

    }
}
