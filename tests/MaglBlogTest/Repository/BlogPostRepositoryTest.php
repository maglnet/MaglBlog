<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlogTest\Repository;

class BlogPostRepositoryTest extends AbstractTestRepository
{

    public function testFindRecent()
    {

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

    public function testFindByYear()
    {

        $limit = 5;

        $queryBuilderMock = $this->getQueryBuilderMock();

        $queryBuilderMock->expects($this->once())
            ->method('addOrderBy')
            ->with('p.createDate', 'DESC')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('where')
            ->with('p.createDate >= :dateStart')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('andWhere')
            ->with('p.createDate < :dateEnd')
            ->willReturn($queryBuilderMock);

        $repoMock = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\BlogPostRepository', $queryBuilderMock);

        $repoMock->findByDate(2014);
    }

    public function testFindByDate()
    {

        $limit = 5;

        $queryBuilderMock = $this->getQueryBuilderMock();

        $queryBuilderMock->expects($this->once())
            ->method('addOrderBy')
            ->with('p.createDate', 'DESC')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('where')
            ->with('p.createDate >= :dateStart')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('andWhere')
            ->with('p.createDate < :dateEnd')
            ->willReturn($queryBuilderMock);

        $repoMock = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\BlogPostRepository', $queryBuilderMock);

        $repoMock->findByDate(2014, 5);
    }

    public function testGetArchiveDateInfo()
    {
        $nativeQueryMock = $this->getMock('\stdClass', array('getArrayResult'), array(), '', false);
        $nativeQueryMock->expects($this->once())
            ->method('getArrayResult')
            ->willReturn(array());

        $emMock = $this->getMock('\Doctrine\ORM\EntityManager', array('createNativeQuery'), array(), '', false);

        $emMock->expects($this->once())
            ->method('createNativeQuery')
            ->willReturn($nativeQueryMock)
            ->with($this->callback(function ($subject) {
                    return stripos($subject, 'YEAR(create_date) AS val_year, MONTH(create_date) AS val_month, COUNT(id) AS val_count') !== false;
                }));

        $rsmMock = $this->getMockBuilder('\Doctrine\ORM\Query\ResultSetMappingBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $rsmMock->expects($this->exactly(3))
            ->method('addScalarResult')
            ->with($this->callback(function ($subject) {
                    return in_array($subject, array('val_year', 'val_month', 'val_count'));
                }), $this->callback(function ($subject) {
                    return in_array($subject, array('year', 'month', 'count'));
                }));

        $repoMock = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\BlogPostRepository', null, array('createResultSetMappingBuilder', 'getEntityManager'));

        $repoMock->expects($this->once())
            ->method('createResultSetMappingBuilder')
            ->with('what')
            ->willReturn($rsmMock);

        $repoMock->expects($this->once())
            ->method('getEntityManager')
            ->willReturn($emMock);

        $limit = 5;

        $repoMock->getArchiveDateInfo($limit);
    }

    public function testGetStartEndDateByYear()
    {

        $repo = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\BlogPostRepository', null);

        $dates = $repo->getStartEndDate(2014);

        $this->assertEquals($dates['dateStart'], new \DateTime('2014-01-01 00:00:00'));
        $this->assertEquals($dates['dateEnd'], new \DateTime('2015-01-01 00:00:00'));

        $this->assertTrue(is_array($dates));
    }

    public function testGetStartEndDateByMonth()
    {

        $repo = $this->getRepositoryMockWithQueryBuilder('\MaglBlog\Repository\BlogPostRepository', null);

        $dates = $repo->getStartEndDate(2014, 02);

        $this->assertEquals($dates['dateStart'], new \DateTime('2014-02-01 00:00:00'));
        $this->assertEquals($dates['dateEnd'], new \DateTime('2014-03-01 00:00:00'));

        $this->assertTrue(is_array($dates));
    }
}
