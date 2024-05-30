<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository;

use App\Core\Business\Exception\ConfigurationException;
use App\Task\Business\Contract\TaskRepositoryInterface;
use App\Task\Business\Domain\Task;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Business\Query\UserFilter;
use App\Task\Infrastructure\Repository\DataMapper\TaskDataMapper;
use Symfony\Component\Filesystem\Filesystem;

class FilesystemTaskRepository implements TaskRepositoryInterface
{
    private const TYPE = 'filesystem';

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
                $this->mapper->mapOne($element);
            }
        }

        throw TaskNotFoundException::forGuid($guid);
    }

    public function findAllBy(UserFilter $filter): array
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

        return $this->mapper->mapMany(array_slice($filteredArray, $filter->getOffset(), $filter->getLimit()));
    }

    public function add(Task $task): void
    {
        $dataAsArray = $this->readFromFile();

        $dataAsArray[] = [
            'guid' => $task->getGuid(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'assigneeId' => $task->getAssigneeId(),
            'status' => $task->getStatus(),
            'dueDate' => $task->getDueDate()->format('Y-m-d'),
        ];

        $this->saveToFile($dataAsArray);
    }

    public function save(Task $task): void
    {
        $dataAsArray = $this->readFromFile();

        foreach ($dataAsArray as $key => $element) {
            if ($element['guid'] === $task->getGuid()) {
                $dataAsArray[$key]['title'] = $task->getTitle();
                $dataAsArray[$key]['description'] = $task->getDescription();
                $dataAsArray[$key]['assigneeId'] = $task->getAssigneeId();
                $dataAsArray[$key]['status'] = $task->getStatus();
                $dataAsArray[$key]['dueDate'] = $task->getDueDate()->format('Y-m-d');
            }
        }

        $this->saveToFile($dataAsArray);
    }

    public function delete(Task $task): void
    {
        $dataAsArray = $this->readFromFile();

        foreach ($dataAsArray as $key => $element) {
            if ($element['guid'] === $task->getGuid()) {
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
