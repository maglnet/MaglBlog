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
class TagServiceTest extends PHPUnit_Framework_TestCase
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
        $tagService = $serviceManager->get('MaglBlog\TagService');

        $this->assertInstanceOf('MaglBlog\Service\TagService', $tagService);
    }

    public function testGetTagCollectionAsString()
    {
        $serviceManager = Bootstrap::getServiceManager();

        $tag1 = new \MaglBlog\Entity\Tag();
        $tag1->setName(' My Tag Name1 ');
        $tag2 = new \MaglBlog\Entity\Tag();
        $tag2->setName(' My Tag Name2 ');
        $tagCollection = new \Doctrine\Common\Collections\ArrayCollection(array(
            $tag1,
            $tag2,
        ));

        $tagService = $serviceManager->get('MaglBlog\TagService');

        $this->assertSame('My Tag Name1, My Tag Name2', $tagService->getTagCollectionAsString($tagCollection));
    }

    public function testGetTagCollectionFromString()
    {
        $serviceManager = Bootstrap::getServiceManager();

        $tag1 = new \MaglBlog\Entity\Tag();
        $tag1->setName('My Tag Name1');
        $tag1->setUrlPart('my-tag-name1');
        $tag2 = new \MaglBlog\Entity\Tag();
        $tag2->setName('My Tag Name2');
        $tag2->setUrlPart('my-tag-name2');
        $tagCollection = new \Doctrine\Common\Collections\ArrayCollection(array(
            $tag1,
            $tag2,
        ));

        $map = array(
          array(array('my-tag-name1'), $tag1),
          array(array('my-tag-name2'), $tag2),
        );

        $tagRepoMock = $this->getMockBuilder('MaglBlog\Repository\TagRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $tagRepoMock->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValueMap($map));

        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('MaglBlog\TagRepository', $tagRepoMock);

        $tagService = $serviceManager->get('MaglBlog\TagService');

        $tagString = ' My Tag Name1 ,  My Tag Name2 ';

        $this->assertEquals($tagCollection, $tagService->getTagCollectionFromString($tagString));
    }

}
