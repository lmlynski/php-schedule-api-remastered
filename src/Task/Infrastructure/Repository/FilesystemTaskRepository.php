<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Infrastructure\Repository;

use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Task\Business\Contract\TaskRepositoryInterface;
use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Exception\TaskNotFoundException;
use ScheduleApiRemastered\Task\Business\Query\Filter\TaskSearchFilter;
use ScheduleApiRemastered\Task\Infrastructure\Repository\DataMapper\TaskDataMapper;
use Symfony\Component\Filesystem\Filesystem;

class FilesystemTaskRepository implements TaskRepositoryInterface
{
    private const string TYPE = 'filesystem';

    /**
     * @throws ConfigurationException
     */
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly TaskDataMapper $mapper,
        private readonly string $dbFile
    ) {
        if (!$this->filesystem->exists($this->dbFile)) {
            throw new ConfigurationException(sprintf('Db file "%s" not found', $this->dbFile));
        }
    }

    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }

    /**
     * @throws TaskNotFoundException
     */
    public function findByGuid(string $guid): Task
    {
        foreach ($this->readFromFile() as $element) {
            if ($element['guid'] === $guid) {
                return $this->mapper->mapOne($element);
            }
        }

        throw TaskNotFoundException::forGuid($guid);
    }

    /**
     * @return Task[]
     */
    public function findAllBy(TaskSearchFilter $filter): array
    {
        $filteredArray = array_filter(
            $this->readFromFile(),
            static function (array $element) use ($filter) {
                foreach ($filter->getCriteria() as $criterion) {
                    if ($element[$criterion->getField()] !== $criterion->getValue()) {
                        return false;
                    }
                }

                return true;
            }
        );

        return $this->mapper->mapMany(array_slice($filteredArray, $filter->getPage()->getOffset(), $filter->getPage()->getLimit()));
    }

    public function add(Task $task): void
    {
        $dataAsArray = $this->readFromFile();

        $dataAsArray[] = [
            'guid' => $task->getGuid()->value,
            'title' => $task->getTitle()->value,
            'description' => $task->getDescription()->value,
            'assigneeId' => $task->getAssigneeId()->value,
            'status' => $task->getStatus(),
            'dueDate' => $task->getDueDate()->value,
        ];

        $this->saveToFile($dataAsArray);
    }

    public function save(Task $task): void
    {
        $dataAsArray = $this->readFromFile();

        foreach ($dataAsArray as $key => $element) {
            if ($element['guid'] === $task->getGuid()->value) {
                $dataAsArray[$key]['title'] = $task->getTitle()->value;
                $dataAsArray[$key]['description'] = $task->getDescription()->value;
                $dataAsArray[$key]['assigneeId'] = $task->getAssigneeId()->value;
                $dataAsArray[$key]['status'] = $task->getStatus()->value;
                $dataAsArray[$key]['dueDate'] = $task->getDueDate()->value;
            }
        }

        $this->saveToFile($dataAsArray);
    }

    public function delete(Task $task): void
    {
        $dataAsArray = $this->readFromFile();

        foreach ($dataAsArray as $key => $element) {
            if ($element['guid'] === $task->getGuid()->value) {
                unset($dataAsArray[$key]);

                break;
            }
        }

        $this->saveToFile($dataAsArray);
    }

    private function readFromFile(): array
    {
        return json_decode(file_get_contents($this->dbFile), true);
    }

    private function saveToFile(array $data): void
    {
        file_put_contents($this->dbFile, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
    }
}
