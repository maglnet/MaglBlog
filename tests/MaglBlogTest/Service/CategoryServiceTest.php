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
class CategoryServiceTest extends PHPUnit_Framework_TestCase
{

    private $categoryCollection;

    public function setUp()
    {
        $cat1 = new \MaglBlog\Entity\Category();
        $cat1->setName('MyName1');
        $cat2 = new \MaglBlog\Entity\Category();
        $cat2->setName('MyName2');

        $this->categoryCollection = new \Doctrine\Common\Collections\ArrayCollection(array(
            $cat1,
            $cat2,
        ));
    }

    public function testGetService()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $categoryService = $serviceManager->get('MaglBlog\CategoryService');

        $this->assertInstanceOf('MaglBlog\Service\CategoryService', $categoryService);
    }

    public function testGetListForWidget()
    {
        $serviceManager = Bootstrap::getServiceManager();

        $catRepoMock = $this->getMockBuilder('MaglBlog\Repository\CategoryRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $catRepoMock->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue($this->categoryCollection));

        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('MaglBlog\CategoryRepository', $catRepoMock);

        $categoryService = $serviceManager->get('MaglBlog\CategoryService');

        $categories = $categoryService->getListForWidget();

        $this->assertSame($categories, $this->categoryCollection);
    }

}
