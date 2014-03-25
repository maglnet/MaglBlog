<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Service;

use DoctrineORMModule\Options\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of Category
 *
 * @author matthias
 */
class BlogPostService implements FactoryInterface
{

	/**
	 *
	 * @var \MaglBlog\Repository\BlogPost
	 */
	private $blogPostRepo;

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$this->blogPostRepo = $serviceLocator->get('MaglBlog\BlogPostRepository');
		return $this;
	}

	/**
	 * 
	 * @return EntityManager
	 */
	private function getEntityManager()
	{
		return $this->em;
	}

	public function getRecent()
	{
		$recentBlogPosts = $this->blogPostRepo->findRecent();
		return $recentBlogPosts;
	}
}
