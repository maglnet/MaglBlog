<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MaglBlog\Repository\TagRepository")
 * @ORM\Table(name="maglblog_tag")
 * 
 */
class Tag
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string") 
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string") 
	 */
	protected $url_part;

	/**
	 * @ORM\ManyToMany(targetEntity="BlogPost", mappedBy="tags")
	 * @ORM\OrderBy({"createDate" = "DESC"})
	 */
	private $blogPosts;

	public function __construct()
	{
		$this->blogPosts = new ArrayCollection();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function getUrlPart()
	{
		return $this->url_part;
	}

	/**
	 * @param @urlPart
	 */
	public function setUrlPart($urlPart)
	{
		$this->url_part = $urlPart;
	}

	/**
	 * @param Collection $blogPosts
	 */
	public function addBlogPosts(Collection $blogPosts)
	{
		foreach ($blogPosts as $blogPost) {
			$this->addBlogPost($blogPost);
		}
	}

	/**
	 * @param BlogPost $blogPost
	 */
	public function addBlogPost(BlogPost $blogPost)
	{
		if (!$this->blogPosts->contains($blogPost)) {
			$this->blogPosts->add($blogPost);
		}
		
		if(!$blogPost->getTags()->contains($this)){
			$blogPost->addTag($this);
		}
		
	}

	/**
	 * @param Collection $blogPosts
	 */
	public function removeBlogPosts(Collection $blogPosts)
	{
		foreach ($blogPosts as $blogPost) {
			$blogPost->removeTag($this);
			$this->blogPosts->removeElement($blogPost);
		}
	}

	/**
	 * @param BlogPost $blogPost
	 */
	public function removeBlogPost(BlogPost $blogPost)
	{
		$blogPost->removeTag($this);
		$this->blogPosts->removeElement($blogPost);
	}

	/**
	 * @return Collection
	 */
	public function getBlogPosts()
	{
		return $this->blogPosts;
	}
}
