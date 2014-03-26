<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Service;

use DoctrineORMModule\Options\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

/**
 * Description of Category
 *
 * @author matthias
 */
class BlogPostService implements FactoryInterface
{

	/**
	 *
	 * @var \MaglBlog\Repository\BlogPostRepository
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
	
	/**
	 * 
	 * @param array|\Doctrine\Common\Collections\Collection $blogPosts
	 * @return ViewModel
	 */
	public function getListView($blogPosts)
	{
		$view = new ViewModel();
		$view->setTemplate('magl-blog/blog/list');
		foreach ($blogPosts as $post) {
			$blogEntryView = new ViewModel(array('post' => $post));
			$blogEntryView->setTemplate('magl-blog/blog/list-entry');
			$view->addChild($blogEntryView, 'blogEntries', true);
		}
		return $view;
	}
}
