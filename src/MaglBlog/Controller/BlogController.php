<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Controller;

use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

/**
 * Description of BlogController
 *
 * @author matthias
 */
class BlogController extends AbstractActionController implements FactoryInterface
{

	/**
	 *
	 * @var EntityManager
	 */
	private $em;

	public function listAction()
	{		
		$blogPostRepo = $this->getEntityManager()->getRepository('\MaglBlog\Entity\BlogPost');
		$blogPosts = $blogPostRepo->findBy(array(), array('createDate' => 'DESC'));

		$view = new ViewModel();
		foreach ($blogPosts as $post) {
			$blogEntryView = new ViewModel(array('post' => $post));
			$blogEntryView->setTemplate('magl-blog/blog/list-entry');
			$view->addChild($blogEntryView, 'blogEntries', true);
		}
		return $view;
	}
	
	public function categoryAction()
	{
		$category = $this->getEntityManager()->find('\MaglBlog\Entity\Category', (int) $this->params('id'));
		if(!$category){
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$blogPosts = $category->getBlogPosts();

		$view = new ViewModel();
		$view->setTemplate('magl-blog/blog/list.phtml');
		foreach ($blogPosts as $post) {
			$blogEntryView = new ViewModel(array('post' => $post));
			$blogEntryView->setTemplate('magl-blog/blog/list-entry');
			$view->addChild($blogEntryView, 'blogEntries', true);
		}
		return $view;
	}

	public function tagAction()
	{
		$tag = $this->getEntityManager()->getRepository('\MaglBlog\Entity\Tag')->findOneByUrlPart($this->params('tagUrlPart'));
		if(!$tag){
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$blogPosts = $tag->getBlogPosts();

		$view = new ViewModel();
		$view->setTemplate('magl-blog/blog/list.phtml');
		foreach ($blogPosts as $post) {
			$blogEntryView = new ViewModel(array('post' => $post));
			$blogEntryView->setTemplate('magl-blog/blog/list-entry');
			$view->addChild($blogEntryView, 'blogEntries', true);
		}
		return $view;
	}

	public function postAction()
	{
		try {
			$blogPostRepo = $this->getEntityManager()->getRepository('\MaglBlog\Entity\BlogPost');
			$blogPost = $blogPostRepo->findOneBy(array('id' => $this->params('id')));

			if (!$this->params('title') || $this->params('title') != $blogPost->getTitleForUrl()) {
				$this->redirect()
						->toRoute('maglblog/post', array('id' => $blogPost->getId(), 'title' => $blogPost->getTitleForUrl()))
						->setStatusCode(301)
				;
				return;
			}
		} catch (Exception $exc) {
			$this->getResponse()->setStatusCode(404);
			return;
		}

		return new ViewModel(array(
			'blogPost' => $blogPost,
		));
	}

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$this->em = $serviceLocator->getServiceLocator()
				->get('Doctrine\ORM\EntityManager');
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

}
