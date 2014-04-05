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
	
}
