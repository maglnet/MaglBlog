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
class CategoryRepository extends EntityRepository 
{

	public function findWithActivePostsCount()
	{
		$queryBuilder = $this->createQueryBuilder('c')
			->select('c as category')
			->addSelect('count(p.id) as activeBlogCount')
			->innerJoin('c.blogPosts','p')
			->groupBy('c.id');
		
		$result = $queryBuilder->getQuery()->getResult();
		return $result;
	}
}
