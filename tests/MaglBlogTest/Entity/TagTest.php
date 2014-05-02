<?php
namespace MaglBlogTest\Entity;

use PHPUnit_Framework_TestCase;

class TagTest extends PHPUnit_Framework_TestCase
{
    public function testTagInitialState()
    {
        $tag = new \MaglBlog\Entity\Tag();

        $this->assertNull($tag->getId());
        $this->assertNull($tag->getName());
        $this->assertNull($tag->getUrlPart());

        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $tag->getBlogPosts());
    }

    public function testSetterAndGetter()
    {
        $tag = new \MaglBlog\Entity\Tag();

        $tag->setId(1);
        $this->assertSame(1, $tag->getId());

        $tag->setName('MyName!!einself!1');
        $this->assertSame('MyName!!einself!1', $tag->getName());

        $tag->setUrlPart('my-url-part');
        $this->assertSame('my-url-part', $tag->getUrlPart());
    }

    public function testAddingOneBlogPost()
    {
        $tag = new \MaglBlog\Entity\Tag();

        $blogPost = new \MaglBlog\Entity\BlogPost();
        $blogPost->setTitle("MyTitle");
        $tag->addBlogPost($blogPost);

        $blogPosts = $tag->getBlogPosts();
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $blogPosts);
        $this->assertTrue($blogPosts->contains($blogPost));

    }

    public function testAddingManyBlogPosts()
    {
        $tag = new \MaglBlog\Entity\Tag();

        $blogPosts = new \Doctrine\Common\Collections\ArrayCollection(
            array(
                new \MaglBlog\Entity\BlogPost(),
                new \MaglBlog\Entity\BlogPost(),
            )
        );

        $tag->addBlogPosts($blogPosts);

        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $blogPosts);
        $this->assertEquals($blogPosts, $tag->getBlogPosts());

    }

    public function testRemovingBlogPosts()
    {
        $tag = new \MaglBlog\Entity\Tag();

        $post1 = new \MaglBlog\Entity\BlogPost();
        $post1->setTitle('Title1');
        $post1->addTag($tag);
        $post2 = new \MaglBlog\Entity\BlogPost();
        $post2->setTitle('Title2');
        $post2->addTag($tag);
        $post3 = new \MaglBlog\Entity\BlogPost();
        $post3->setTitle('Title3');
        $post3->addTag($tag);

        $blogPostsIn = new \Doctrine\Common\Collections\ArrayCollection(
            array(
                $post1,
                $post2,
                $post3,
            )
        );

        $tag->addBlogPosts($blogPostsIn);
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $tag->getBlogPosts());
        $this->assertEquals($blogPostsIn, $tag->getBlogPosts());


        $tag->removeBlogPosts($blogPostsIn);
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $tag->getBlogPosts());
        $this->assertEquals(true, $tag->getBlogPosts()->isEmpty());


    }

    public function testRemovingBlogPost()
    {
        $tag = new \MaglBlog\Entity\Tag();

        $post1 = new \MaglBlog\Entity\BlogPost();
        $post1->setTitle('Title1');
        $post1->addTag($tag);
        $post2 = new \MaglBlog\Entity\BlogPost();
        $post2->setTitle('Title2');
        $post2->addTag($tag);
        $post3 = new \MaglBlog\Entity\BlogPost();
        $post3->setTitle('Title3');
        $post3->addTag($tag);

        $blogPostsIn = new \Doctrine\Common\Collections\ArrayCollection(
            array(
                $post1,
                $post2,
                $post3,
            )
        );
        $tag->addBlogPosts($blogPostsIn);

        $tag->removeBlogPost($post2);
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $tag->getBlogPosts());
        $this->assertEquals(true, $tag->getBlogPosts()->contains($post1));
        $this->assertEquals(true, $tag->getBlogPosts()->contains($post3));
        $this->assertEquals(false, $tag->getBlogPosts()->contains($post2));


    }


}
