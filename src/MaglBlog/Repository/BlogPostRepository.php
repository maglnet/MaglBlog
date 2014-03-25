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

	public function findRecent()
	{
		$em = $this->getEntityManager();
		$query = $em->createQuery('SELECT p FROM MaglBlog\Entity\BlogPost p ORDER BY p.createDate DESC');
		$query->setMaxResults(2);
		$result = $query->getResult();
		return $result;
	}
	
}
