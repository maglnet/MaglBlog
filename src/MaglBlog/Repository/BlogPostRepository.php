<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of Category
 *
 * @author matthias
 */
class BlogPostRepository extends EntityRepository
{

	/**
	 * @param integer $limit
	 */
	public function findRecent($limit)
	{
		$queryBuilder = $this->createQueryBuilder('p')
			->addOrderBy('p.createDate', 'DESC')
			->setMaxResults((int)$limit);
		
		$result = $queryBuilder->getQuery()->getResult();
		return $result;
	}
	
	/**
	 * @param integer $limit
	 * @param integer $year
	 * @param integer|null $month
	 */
	public function findByDate($limit, $year, $month = null)
	{
		$dates = $this->getStartEndDate($year, $month);
		
		$queryBuilder = $this->createQueryBuilder('p')
			->where('p.createDate >= :dateStart')
			->andWhere('p.createDate < :dateEnd')
			->addOrderBy('p.createDate', 'DESC')
			->setMaxResults((int)$limit);
		
		$queryBuilder->setParameter('dateStart', $dates['dateStart'], \Doctrine\DBAL\Types\Type::DATETIME);
		$queryBuilder->setParameter('dateEnd', $dates['dateEnd'], \Doctrine\DBAL\Types\Type::DATETIME);
		
		$result = $queryBuilder->getQuery()->getResult();
		return $result;
	}
	
	public function getStartEndDate($year, $month = null){
		
		$dates = array();
		
		$year = (int)$year;
		
		if(null == $month){
			$month = '01';
            $interval = 'P1Y';
		} else {
			$month = sprintf("%02d", $month);
            $interval = 'P1M';
		}
        
        $dates['dateStart'] = new \DateTime($year.'-'.$month.'-01 00:00:00');
        $dates['dateEnd'] = clone $dates['dateStart'];
        $dates['dateEnd']->add(new \DateInterval($interval));
		
		return $dates;
	}
	
}
