<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlogTest\Repository;

class CategoryRepositoryTest extends AbstractTestRepository
{
    public function testFindWithActivePostsCount()
    {
        $queryBuilderMock = $this->getQueryBuilderMock();

        $queryBuilderMock->expects($this->once())
            ->method('select')
            ->with('c as category')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('addSelect')
            ->with('count(p.id) as activeBlogCount')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('innerJoin')
            ->with('c.blogPosts','p')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('groupBy')
            ->with('c.id')
            ->willReturn($queryBuilderMock);

        $repoMock = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\CategoryRepository', $queryBuilderMock);

        $repoMock->findWithActivePostsCount();

    }
}
