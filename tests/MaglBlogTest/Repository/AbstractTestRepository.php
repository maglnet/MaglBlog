<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlogTest\Repository;


class MaglBlogQueryMock
{
    public function getResult()
    {
        return array();
    }
}

class AbstractTestRepository extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRepositoryMockWithQueryBuilder($repositoryClassName, $queryBuilderMock = null, $functionsToMock = array())
    {
        $functionsToMock = array_merge(array('insert', 'update', 'createQueryBuilder'), $functionsToMock);


        $repoMock = $this->getMockBuilder($repositoryClassName)
            ->disableOriginalConstructor()
            ->setMethods($functionsToMock)
            ->getMock();

        if(null !== $queryBuilderMock) {
            $repoMock->expects($this->once())
                ->method('createQueryBuilder')
                ->willReturn($queryBuilderMock);
        }

        return $repoMock;
    }

    /**
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getQueryBuilderMock()
    {
        $queryBuilderMock =  $this->getMockBuilder('\Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $queryBuilderMock->expects($this->once())
            ->method('getQuery')
            ->willReturn(new MaglBlogQueryMock());

        return $queryBuilderMock;
    }
}
