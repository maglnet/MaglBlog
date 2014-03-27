<?php
namespace MaglBlogTest\Entity;

use PHPUnit_Framework_TestCase;

class BlogPostTest extends PHPUnit_Framework_TestCase
{
    public function testBlogPostInitialState()
    {
        $post = new \MaglBlog\Entity\BlogPost();

        $this->assertNull($post->getId());
        $this->assertNull($post->getText());
        $this->assertNull($post->getTitle());
        $this->assertNull($post->getTeaserText());
        $this->assertNull($post->getAuthorId());
        $this->assertNull($post->getCreateDate());
        $this->assertNull($post->getUpdateDate());
        $this->assertNull($post->getCategory());
		
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $post->getTags());
    }

	public function testSetterAndGetter()
    {
        $post = new \MaglBlog\Entity\BlogPost();

		$post->setId(1);
        $this->assertSame(1, $post->getId());
		
		$post->setTitle('MyName!!einself!1');
        $this->assertSame('MyName!!einself!1', $post->getTitle());
		
		$post->setTeaserText('Yeah, this is great!');
        $this->assertSame('Yeah, this is great!', $post->getTeaserText());
		
		$post->setText('Yeah, this is great, too!');
        $this->assertSame('Yeah, this is great, too!', $post->getText());
		
		$createDate = new \DateTime('2014-01-01 15:25');
		$post->setCreateDate($createDate);
        $this->assertSame($createDate, $post->getCreateDate());
		
		$updateDate = new \DateTime('2013-01-01 15:25');
		$post->setUpdateDate($updateDate);
        $this->assertSame($updateDate, $post->getUpdateDate());
		
		$post->setAuthorId(1);
		$this->assertSame(1, $post->getAuthorId());
		
		$cat = new \MaglBlog\Entity\Category();
		$post->setCategory($cat);
        $this->assertSame($cat, $post->getCategory());
		$post->setCategory(null);
        $this->assertNull($post->getCategory());
		

    }
	
	public function testSettingGettingTags()
	{
		$post = new \MaglBlog\Entity\BlogPost();

		$tag1 = new \MaglBlog\Entity\Tag();
		$tag1->setName('MyTag1');
		$tag2 = new \MaglBlog\Entity\Tag();
		$tag2->setName('MyTag2');
		$tag3 = new \MaglBlog\Entity\Tag();
		$tag3->setName('MyTag3');
		
		$tags1 = new \Doctrine\Common\Collections\ArrayCollection(array(
			$tag1,
			$tag2,
		));
		
		$tags2 = clone $tags1;
		
		// multi add
		$post->addTags($tags1);
		$this->assertSame(2, $post->getTags()->count());
		$this->assertSame(true, $post->getTags()->contains($tag1));
		$this->assertSame(true, $post->getTags()->contains($tag2));

		$post->removeTags($tags1);
		$this->assertSame(true, $post->getTags()->isEmpty());
		
		// single add / remove
		$post->addTag($tag1);
		$this->assertSame(1, $post->getTags()->count());
		$this->assertSame(true, $post->getTags()->contains($tag1));
		
		$post->addTag($tag2);
		$this->assertSame(2, $post->getTags()->count());
		$this->assertSame(true, $post->getTags()->contains($tag2));
		
		$post->removeTag($tag1);
		$this->assertSame(1, $post->getTags()->count());
		$this->assertSame(true, $post->getTags()->contains($tag2));
		$this->assertSame(false, $post->getTags()->contains($tag1));
		
		$post->removeTag($tag2);
		$this->assertSame(0, $post->getTags()->count());
		$this->assertSame(false, $post->getTags()->contains($tag2));
		$this->assertSame(false, $post->getTags()->contains($tag1));
		
		// multi set / remove
		$post->setTags($tags1);
		$this->assertSame(2, $post->getTags()->count());
		$this->assertSame(true, $post->getTags()->contains($tag1));
		$this->assertSame(true, $post->getTags()->contains($tag2));
		
		$post->addTag($tag3);
		$this->assertSame(3, $post->getTags()->count());
		$this->assertSame(true, $post->getTags()->contains($tag1));
		$this->assertSame(true, $post->getTags()->contains($tag2));
		$this->assertSame(true, $post->getTags()->contains($tag3));
		
		$post->removeTags($tags2);
		$this->assertSame(1, $post->getTags()->count());
		$this->assertSame(false, $post->getTags()->contains($tag1));
		$this->assertSame(false, $post->getTags()->contains($tag2));
		$this->assertSame(true, $post->getTags()->contains($tag3));
	}
	
	public function testGetUrlTitle(){
		$post = new \MaglBlog\Entity\BlogPost();
		
		$post->setTitle('Yeah, this is great!');
		$this->assertSame('yeah-this-is-great', $post->getTitleForUrl());
		
	}
	
}
