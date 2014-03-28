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
	
	/**
	 *
	 * @var \Zend\ServiceManager\ServiceManager
	 */
	private $sm;

	/**
	 *
	 * @var \MaglBlog\Repository\CategoryRepository
	 */
	private $catRepo;
	
	/**
	 *
	 * @var \MaglBlog\Repository\BlogPostRepository
	 */
	private $blogPostRepo;

	/**
	 *
	 * @var \MaglBlog\Repository\TagRepository
	 */
	private $tagRepo;

	public function listAction()
	{		
		$blogPosts = $this->getBlogPostRepository()->findBy(array(), array('createDate' => 'DESC'));
		return $this->sm->get('MaglBlog\BlogPostService')->getListView($blogPosts);
	}
	
	public function categoryAction()
	{
		$category = $this->getCategoryRepository()->find((int) $this->params('id'));
		if(!$category){
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$blogPosts = $category->getBlogPosts();

		return $this->sm->get('MaglBlog\BlogPostService')->getListView($blogPosts);
	}

	public function tagAction()
	{
		$tag = $this->getTagRepository()->findOneByUrlPart($this->params('tagUrlPart'));
		if(!$tag){
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$blogPosts = $tag->getBlogPosts();

		return $this->sm->get('MaglBlog\BlogPostService')->getListView($blogPosts);
	}

	public function postAction()
	{
		try {
			$blogPost = $this->getBlogPostRepository()->find((int) $this->params('id'));

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
		$this->sm = $serviceLocator->getServiceLocator();
		$this->em = $this->sm->get('Doctrine\ORM\EntityManager');
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

	/**
	 * 
	 * @return \MaglBlog\Repository\CategoryRepository
	 */
	private function getCategoryRepository(){
		if(null == $this->catRepo){
			$this->catRepo = $this->sm->get('MaglBlog\CategoryRepository');
		}
		return $this->catRepo;
	}
	
	/**
	 * 
	 * @return \MaglBlog\Repository\BlogPostRepository
	 */
	private function getBlogPostRepository(){
		if(null == $this->blogPostRepo){
			$this->blogPostRepo = $this->sm->get('MaglBlog\BlogPostRepository');
		}
		return $this->blogPostRepo;
	}
	
	/**
	 * 
	 * @return \MaglBlog\Repository\TagRepository
	 */
	private function getTagRepository(){
		if(null == $this->tagRepo){
			$this->tagRepo = $this->sm->get('MaglBlog\TagRepository');
		}
		return $this->tagRepo;
	}
}
