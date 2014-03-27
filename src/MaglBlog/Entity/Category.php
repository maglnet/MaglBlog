<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MaglBlog\Repository\CategoryRepository")
 * @ORM\Table(name="maglblog_category")
 * 
 */
class Category
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * 
	 * @ORM\Column(type="text")
	 */
	protected $name;

	/**
	 * 
	 * @var \Doctrine\Common\Collections\Collection
	 * 
	 * @ORM\OneToMany(targetEntity="BlogPost", mappedBy="category")
	 * @ORM\OrderBy({"createDate" = "DESC"})
	 */
	protected $blogPosts;

	public function __construct()
	{
		$this->blogPosts = new ArrayCollection();
	}

	/**
	 * 
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * 
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * 
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * 
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getBlogPosts()
	{
		return $this->blogPosts;
	}

	/**
	 * 
	 * @param \Doctrine\Common\Collections\Collection $blogPosts
	 */
	public function setBlogPosts(\Doctrine\Common\Collections\Collection $blogPosts)
	{
		$this->blogPosts = $blogPosts;
	}
}
