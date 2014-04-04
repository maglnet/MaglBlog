<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlogTest\Repository;

class BlogPostRepositoryTest extends AbstractTestRepository
{
	public function testFindRecent(){
		
		$limit = 5;
		
		$queryBuilderMock = $this->getQueryBuilderMock();
		
		$queryBuilderMock->expects($this->once())
			->method('addOrderBy')
			->with('p.createDate', 'DESC')
			->willReturn($queryBuilderMock);
		
		$queryBuilderMock->expects($this->once())
			->method('setMaxResults')
			->with($limit)
			->willReturn($queryBuilderMock);
		
		$repoMock = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\BlogPostRepository', $queryBuilderMock);
		
		$repoMock->findRecent($limit);
		
	}
}

