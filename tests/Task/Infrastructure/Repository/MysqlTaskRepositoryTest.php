<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Tests\Task\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ScheduleApiRemastered\Core\Business\Domain\Criterion;
use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskAssigneeId;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDescription;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDueDate;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskGuid;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskStatus;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskTitle;
use ScheduleApiRemastered\Task\Business\Exception\TaskNotFoundException;
use ScheduleApiRemastered\Task\Business\Query\UserFilter;
use ScheduleApiRemastered\Task\Infrastructure\Repository\DataMapper\TaskDataMapper;
use ScheduleApiRemastered\Task\Infrastructure\Repository\MysqlTaskRepository;

class MysqlTaskRepositoryTest extends TestCase
{
    /** @var Connection&MockObject */
    private Connection $connection;
    private MysqlTaskRepository $repository;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(Connection::class);
        $this->repository = new MysqlTaskRepository($this->connection, new TaskDataMapper());
    }

    protected function tearDown(): void
    {
        unset($this->connection, $this->repository);
    }

    /**
     * @throws Exception
     */
    public function testFindByGuidWithNoTaskFoundWillThrowTaskNotFoundException(): void
    {
        self::expectException(TaskNotFoundException::class);
        self::expectExceptionMessage('Task for guid "some-guid" not found');

        $guid = 'some-guid';

        $this->connection
            ->expects(self::once())
            ->method('fetchAssociative')
            ->with(
                'SELECT * FROM task WHERE guid = :guid',
                [
                    'guid' => $guid,
                ]
            )
            ->willReturn([]);

        $this->repository->findByGuid($guid);
    }

    /**
     * @throws Exception
     */
    public function testFindByGuidWithTaskFoundWillReturnTaskObject(): void
    {
        $guid = '05fe9fbd-273b-4878-8d4b-349e50318c2d';
        $taskFromDb = [
            'guid' => $guid,
            'title' => 'some-title',
            'description' => 'some-description',
            'assigneeId' => '5966c003-b09b-40a3-abc7-cfcb6c31a954',
            'status' => 'new',
            'dueDate' => '2024-05-25',
        ];

        $this->connection
            ->expects(self::once())
            ->method('fetchAssociative')
            ->with(
                'SELECT * FROM task WHERE guid = :guid',
                [
                    'guid' => $guid,
                ]
            )
            ->willReturn($taskFromDb);

        $result = $this->repository->findByGuid($guid);

        self::assertInstanceOf(Task::class, $result);
        self::assertSame($guid, $result->getGuid()->value);
        self::assertSame('some-title', $result->getTitle()->value);
        self::assertSame('some-description', $result->getDescription()->value);
        self::assertSame('5966c003-b09b-40a3-abc7-cfcb6c31a954', $result->getAssigneeId()->value);
        self::assertSame('new', $result->getStatus()->value);
        self::assertSame('2024-05-25', $result->getDueDate()->value);
    }

    /**
     * @throws Exception
     */
    public function testFindAllBydWithFilterCriteriaAndTasksFoundWillReturnCollection(): void
    {
        $tasksFromDb = [
            [
                'guid' => '05fe9fbd-273b-4878-8d4b-349e50318c2d',
                'title' => 'some-title',
                'description' => 'some-description',
                'assigneeId' => '5966c003-b09b-40a3-abc7-cfcb6c31a954',
                'status' => 'new',
                'dueDate' => '2024-05-25',
            ],
            [
                'guid' => '05fe9fbd-273b-4878-8d4b-349e50318c2e',
                'title' => 'some-title-2',
                'description' => 'some-description-2',
                'assigneeId' => '5966c003-b09b-40a3-abc7-cfcb6c31a954',
                'status' => 'new',
                'dueDate' => '2024-05-25',
            ],
        ];

        $this->connection
            ->expects(self::once())
            ->method('fetchAllAssociative')
            ->with('SELECT * FROM task WHERE status = \'new\' LIMIT 20 OFFSET 0')
            ->willReturn($tasksFromDb);

        $result = $this->repository->findAllBy(
            (new UserFilter())->addCriterion(new Criterion('status', 'new')),
        );

        self::assertCount(2, $result);
        self::assertInstanceOf(Task::class, $result[0]);
        self::assertInstanceOf(Task::class, $result[1]);
    }

    /**
     * @throws Exception
     */
    public function testFindAllBydWithFilterCriteriaAndNoTasksFoundWillReturnEmptyArray(): void
    {
        $tasksFromDb = [];

        $this->connection
            ->expects(self::once())
            ->method('fetchAllAssociative')
            ->with('SELECT * FROM task WHERE status = \'new\' LIMIT 20 OFFSET 0')
            ->willReturn($tasksFromDb);

        $result = $this->repository->findAllBy(
            (new UserFilter())->addCriterion(new Criterion('status', 'new')),
        );

        self::assertCount(0, $result);
        self::assertSame([], $result);
    }

    /**
     * @throws Exception
     */
    public function testAddWillAddNewTaskToDatabase(): void
    {
        $task = new Task(
            new TaskGuid('05fe9fbd-273b-4878-8d4b-349e50318c2e'),
            new TaskTitle('some-title'),
            new TaskDescription('some-description'),
            new TaskAssigneeId('5966c003-b09b-40a3-abc7-cfcb6c31a954'),
            TaskStatus::from('new'),
            new TaskDueDate('2024-05-22')
        );

        $this->connection
            ->expects(self::once())
            ->method('executeStatement')
            ->with(
                'INSERT INTO task (guid, title, description, assigneeId, status, dueDate)
                VALUES (:guid, :title, :description, :assigneeId, :status, :dueDate)',
                [
                    'guid' => '05fe9fbd-273b-4878-8d4b-349e50318c2e',
                    'title' => 'some-title',
                    'description' => 'some-description',
                    'assigneeId' => '5966c003-b09b-40a3-abc7-cfcb6c31a954',
                    'status' => 'new',
                    'dueDate' => '2024-05-22',
                ]
            );

        $this->repository->add($task);
    }

    /**
     * @throws Exception
     */
    public function testSaveWillSaveNewTaskToDatabase(): void
    {
        $task = new Task(
            new TaskGuid('05fe9fbd-273b-4878-8d4b-349e50318c2e'),
            new TaskTitle('some-title'),
            new TaskDescription('some-description'),
            new TaskAssigneeId('5966c003-b09b-40a3-abc7-cfcb6c31a954'),
            TaskStatus::from('new'),
            new TaskDueDate('2024-05-22')
        );

        $this->connection
            ->expects(self::once())
            ->method('executeStatement')
            ->with(
                'REPLACE INTO task (guid, title, description, assigneeId, status, dueDate)
                 VALUES (:guid, :title, :description, :assigneeId, :status, :dueDate)',
                [
                    'guid' => '05fe9fbd-273b-4878-8d4b-349e50318c2e',
                    'title' => 'some-title',
                    'description' => 'some-description',
                    'assigneeId' => '5966c003-b09b-40a3-abc7-cfcb6c31a954',
                    'status' => 'new',
                    'dueDate' => '2024-05-22',
                ]
            );

        $this->repository->save($task);
    }

    /**
     * @throws Exception
     */
    public function testDeleteWillDeleteNewTaskToDatabase(): void
    {
        $task = new Task(
            new TaskGuid('05fe9fbd-273b-4878-8d4b-349e50318c2e'),
            new TaskTitle('some-title'),
            new TaskDescription('some-description'),
            new TaskAssigneeId('5966c003-b09b-40a3-abc7-cfcb6c31a954'),
            TaskStatus::from('new'),
            new TaskDueDate('2024-05-22')
        );

        $this->connection
            ->expects(self::once())
            ->method('executeStatement')
            ->with(
                'DELETE FROM task WHERE guid = :guid',
                [
                    'guid' => '05fe9fbd-273b-4878-8d4b-349e50318c2e',
                ]
            );

        $this->repository->delete($task);
    }
}
