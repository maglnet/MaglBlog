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
		$em = $this->getEntityManager();
		$query = $em->createQuery('SELECT c as category, count(p.id) as activeBlogCount FROM MaglBlog\Entity\Category c JOIN c.blogPosts p GROUP BY c.id');
		$result = $query->getResult();
		return $result;
	}
}
