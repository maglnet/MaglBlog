<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaglBlogTest\Controller;

use MaglBlogTest\Bootstrap;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;

/**
 * Description of BlogControllerTest
 *
 * @author matthias
 */
class BlogControllerTest extends AbstractHttpControllerTestCase
{

protected function setUp()
    {
//        $serviceManager = Bootstrap::getServiceManager();
//		$applicationConfig = $serviceManager->get('ApplicationConfig');
//		
//        $this->controller = new \MaglBlog\Controller\BlogController();
//        $this->request    = new Request();
//        //$this->routeMatch = new RouteMatch(array('controller' => 'BlogController'));
//        $this->event      = new MvcEvent();
//        $config = $serviceManager->get('Config');
//        $routerConfig = isset($config['router']) ? $config['router'] : array();
//        $router = HttpRouter::factory($routerConfig);
//
//        $this->event->setRouter($router);
//        //$this->event->setRouteMatch($this->routeMatch);
//        $this->controller->setEvent($this->event);
//        $this->controller->setServiceLocator($serviceManager);
//		
//		$this->setApplicationConfig($applicationConfig);
    }

	public function testDefaultRouteToList()
	{
//		$blogPostRepoMock = $this->getMockBuilder('MaglBlog\Repository\BlogPostRepository')
//								->disableOriginalConstructor()
//								->getMock();
//
//		$blogPostRepoMock->expects($this->once())
//						->method('findBy')
//						->will($this->returnValue(array()));
//
//		$serviceManager = Bootstrap::getServiceManager();
//		$serviceManager->setAllowOverride(true);
//		$serviceManager->setService('MaglBlog\BlogPostRepository', $blogPostRepoMock);
//
//		$this->dispatch('/blog');
//		$this->assertResponseStatusCode(200);
//
//		$this->assertModuleName('MaglBlog');
//		$this->assertControllerName('MaglBlog\Controller\BlogController');
//		$this->assertControllerClass('BlogController');
//		$this->assertMatchedRouteName('maglblog');
	}
}
