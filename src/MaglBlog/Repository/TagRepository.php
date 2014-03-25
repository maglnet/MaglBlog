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
class TagRepository extends EntityRepository 
{

	public function findWithPostCount()
	{
		$em = $this->getEntityManager();
		$query = $em->createQuery('SELECT t as tag, count(p.id) as postCount FROM MaglBlog\Entity\Tag t JOIN t.blogPosts p GROUP BY t.id');
		$result = $query->getResult();
		return $result;
	}
	
	public function findOneByUrlPart($urlPart)
	{
		return $this->findOneBy(array('url_part' => $urlPart));
	}
}
