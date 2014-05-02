<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlogTest\Repository;

class TagRepositoryTest extends AbstractTestRepository
{
    public function testFindWithPostCount()
    {
        $queryBuilderMock = $this->getQueryBuilderMock();

        $queryBuilderMock->expects($this->once())
            ->method('select')
            ->with('t as tag')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('addSelect')
            ->with('count(p.id) as postCount')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('innerJoin')
            ->with('t.blogPosts','p')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('groupBy')
            ->with('t.id')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('orderBY')
            ->with('t.name')
            ->willReturn($queryBuilderMock);

        $repoMock = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\TagRepository', $queryBuilderMock);

        $repoMock->findWithPostCount();
    }

    public function testFindOneByUrlPart()
    {
        $url_part = 'something-to-test-against';

        $repoMock = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\TagRepository', null, array('findOneBy'));
        $repoMock->expects($this->once())
            ->method('findOneBy')
            ->with(array('url_part' => $url_part));

        $repoMock->findOneByUrlPart($url_part);
    }
}
