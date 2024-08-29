<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Tests\Unit\Task\Infrastructure\Repository\Resolver;

use PHPUnit\Framework\TestCase;
use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Task\Business\Contract\TaskRepositoryInterface;
use ScheduleApiRemastered\Task\Infrastructure\Repository\Resolver\TaskWriteRepositoryResolver;

class TaskWriteRepositoryResolverTest extends TestCase
{
    public function testGetWithNoRepositoryAddedWillThrowConfigurationException(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage('Unsupported write repository type "some_repo_type"');

        (new TaskWriteRepositoryResolver('some_repo_type'))->get();
    }

    public function testGetWithRepositoriesAddedButAllHaveWrongRepoTypWillThrowConfigurationException(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage('Unsupported write repository type "some_repo_type"');

        $repoType = 'some_repo_type';

        $repositoryOne = $this->createMock(TaskRepositoryInterface::class);
        $repositoryOne
            ->expects(self::any())
            ->method('supports')
            ->with($repoType)
            ->willReturn(false);

        $repositoryTwo = $this->createMock(TaskRepositoryInterface::class);
        $repositoryTwo
            ->expects(self::any())
            ->method('supports')
            ->with($repoType)
            ->willReturn(false);

        $resolver = new TaskWriteRepositoryResolver($repoType);
        $resolver->addRepository($repositoryOne);
        $resolver->addRepository($repositoryTwo);

        $resolver->get();
    }

    /**
     * @throws ConfigurationException
     */
    public function testGetWithTwoRepositoriesAddedWillReturnFirstOneThatHasCorrectRepoType(): void
    {
        $repoType = 'some_repo_type';

        $repositoryOne = $this->createMock(TaskRepositoryInterface::class);
        $repositoryOne
            ->expects(self::any())
            ->method('supports')
            ->with($repoType)
            ->willReturn(true);

        $repositoryTwo = $this->createMock(TaskRepositoryInterface::class);
        $repositoryTwo
            ->expects(self::never())
            ->method('supports');

        $resolver = new TaskWriteRepositoryResolver($repoType);
        $resolver->addRepository($repositoryOne);
        $resolver->addRepository($repositoryTwo);

        self::assertSame($repositoryOne, $resolver->get());
    }

    /**
     * @throws ConfigurationException
     */
    public function testGetWithTwoRepositoriesAddedWillReturnTheSecondOne(): void
    {
        $repoType = 'some_repo_type';

        $repositoryOne = $this->createMock(TaskRepositoryInterface::class);
        $repositoryOne
            ->expects(self::any())
            ->method('supports')
            ->with($repoType)
            ->willReturn(false);

        $repositoryTwo = $this->createMock(TaskRepositoryInterface::class);
        $repositoryTwo
            ->expects(self::any())
            ->method('supports')
            ->with($repoType)
            ->willReturn(true);

        $resolver = new TaskWriteRepositoryResolver($repoType);
        $resolver->addRepository($repositoryOne);
        $resolver->addRepository($repositoryTwo);

        self::assertSame($repositoryTwo, $resolver->get());
    }
}
