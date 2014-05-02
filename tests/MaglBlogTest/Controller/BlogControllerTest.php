<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlogTest\Controller;

use DateTime;
use MaglBlog\Entity\BlogPost;
use MaglBlogTest\Bootstrap;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BlogControllerTest extends AbstractHttpControllerTestCase
{

    private $sm;
    protected $traceError = true;

    protected function setUp()
    {
        $this->sm = Bootstrap::getServiceManager();
        $applicationConfig = $this->sm->get('ApplicationConfig');

        $this->setApplicationConfig($applicationConfig);
    }

    public function testDefaultRouteToList()
    {
        $blogPostRepoMock = $this->getMockBuilder('MaglBlog\Repository\BlogPostRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $blogPostRepoMock->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array()));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('MaglBlog\BlogPostRepository', $blogPostRepoMock);


        $this->dispatch('/blog');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('MaglBlog');
        $this->assertControllerName('MaglBlog\Controller\Blog');
        $this->assertActionName('list');
    }

    public function testPostNotFound()
    {
        $blogPostRepoMock = $this->getMockBuilder('MaglBlog\Repository\BlogPostRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $blogPostRepoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(array()));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('MaglBlog\BlogPostRepository', $blogPostRepoMock);


        $this->dispatch('/blog/post/1');

        $this->assertResponseStatusCode(404);
        $this->assertModuleName('MaglBlog');
        $this->assertControllerName('MaglBlog\Controller\Blog');
        $this->assertActionName('post');
    }

    public function testPostRedirect()
    {

        $blogPost = new BlogPost();
        $blogPost->setId(1);
        $blogPost->setTitle('This is a Test');

        $blogPostRepoMock = $this->getMockBuilder('MaglBlog\Repository\BlogPostRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $blogPostRepoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue($blogPost));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('MaglBlog\BlogPostRepository', $blogPostRepoMock);


        $this->dispatch('/blog/post/1');

        $this->assertResponseStatusCode(301);
        $this->assertModuleName('MaglBlog');
        $this->assertControllerName('MaglBlog\Controller\Blog');
        $this->assertActionName('post');
    }

    public function testPostFound()
    {
        $blogPost = new BlogPost();
        $blogPost->setId(1);
        $blogPost->setTitle('This is a Test');
        $blogPost->setCreateDate(new DateTime('now'));
        $blogPost->setUpdateDate(new DateTime('now'));

        $blogPostRepoMock = $this->getMockBuilder('MaglBlog\Repository\BlogPostRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $blogPostRepoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue($blogPost));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('MaglBlog\BlogPostRepository', $blogPostRepoMock);


        $this->dispatch('/blog/post/1/this-is-a-test');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('MaglBlog');
        $this->assertControllerName('MaglBlog\Controller\Blog');
        $this->assertActionName('post');
    }
}
