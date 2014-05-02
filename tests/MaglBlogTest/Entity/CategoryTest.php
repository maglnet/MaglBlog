<?php
namespace MaglBlogTest\Entity;

use PHPUnit_Framework_TestCase;

class CategoryTest extends PHPUnit_Framework_TestCase
{
    public function testCategoryInitialState()
    {
        $cat = new \MaglBlog\Entity\Category();

        $this->assertNull($cat->getId());
        $this->assertNull($cat->getName());

        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $cat->getBlogPosts());
    }

    public function testSetterAndGetter()
    {
        $cat = new \MaglBlog\Entity\Category();

        $cat->setId(1);
        $this->assertSame(1, $cat->getId());

        $cat->setName('MyName!!einself!1');
        $this->assertSame('MyName!!einself!1', $cat->getName());

        $blogCollection = new \Doctrine\Common\Collections\ArrayCollection();
        $blogCollection->add(new \MaglBlog\Entity\BlogPost());
        $blogCollection->add(new \MaglBlog\Entity\BlogPost());

        $cat->setBlogPosts($blogCollection);
        $this->assertSame($blogCollection, $cat->getBlogPosts());
    }

}
