<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaglBlogTest\Service;

use MaglBlogTest\Bootstrap;
use PHPUnit_Framework_TestCase;

/**
 * Description of BlogPostServiceTest
 *
 * @author matthias
 */
class BlogPostServiceTest extends PHPUnit_Framework_TestCase
{
	
	private $blogPostCollection;
	
	public function setUp()
	{
		$blogPost1 = new \MaglBlog\Entity\BlogPost();
		$blogPost1->setTitle('MyTitle1');
		$blogPost2 = new \MaglBlog\Entity\BlogPost();
		$blogPost2->setTitle('MyTitle2');
		
		$this->blogPostCollection = new \Doctrine\Common\Collections\ArrayCollection(array(
			$blogPost1,
			$blogPost2,
		));
	}
	
	public function testGetRecent(){

		$serviceManager = Bootstrap::getServiceManager();
		
		$blogPostRepoMock = $this->getMockBuilder('MaglBlog\Repository\BlogPostRepository')
			->disableOriginalConstructor()
			->getMock();

		$blogPostRepoMock->expects($this->once())
			->method('findRecent')
			->will($this->returnValue($this->blogPostCollection));
		
		$serviceManager->setAllowOverride(true);
		$serviceManager->setService('MaglBlog\BlogPostRepository', $blogPostRepoMock);
		
		$blogPostService = $serviceManager->get('MaglBlog\BlogPostService');
		
		$blogPosts = $blogPostService->getRecent(2);
		
		$this->assertSame($blogPosts, $this->blogPostCollection);
	}
	
	
	public function testGetBlogPostListView(){

		$serviceManager = Bootstrap::getServiceManager();
		$blogPostService = $serviceManager->get('MaglBlog\BlogPostService');
		
		/* @var $view \Zend\View\Model\ViewModel */
		$view = $blogPostService->getListView($this->blogPostCollection);
		
		// check parent
		$this->assertInstanceOf('\Zend\View\Model\ViewModel', $view);
		$this->assertSame('magl-blog/blog/list', $view->getTemplate());
		$this->assertTrue($view->hasChildren());
		
		// check children
		$this->assertSame(2, $view->count());
		foreach($view->getChildren() as $viewChild){
			/* @var $viewChild \Zend\View\Model\ViewModel */
			$this->assertInstanceOf('\Zend\View\Model\ViewModel', $viewChild);
			$this->assertSame('magl-blog/blog/list-entry', $viewChild->getTemplate());
			$this->assertInstanceOf('\MaglBlog\Entity\BlogPost', $viewChild->getVariable('post'));
		}
		
	}
}
