<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaglBlogTest\View\Helper;

use MaglBlogTest\Bootstrap;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\View\HelperPluginManager;

/**
 * Description of BlogUrlToPostTest
 *
 * @author matthias
 */
class BlogUrlToPostTest extends AbstractHttpControllerTestCase
{
	/**
	 *
	 * @var ServiceManager
	 */
	private $sm;
	
	public function setUp(){
		$this->sm = Bootstrap::getServiceManager();
	}
	
	public function testGetViewHelper()
	{
		/* @var $view HelperPluginManager */
		$viewHelper = $this->sm->get('ViewHelperManager');
		$viewHelper->setInvokableClass('url', 'Zend\View\Helper\Url');

		$blogPostUrl = $viewHelper->get('BlogUrlToPost');
		$this->assertInstanceOf('MaglBlog\View\Helper\BlogUrlToPost', $blogPostUrl);
		
	}

}
