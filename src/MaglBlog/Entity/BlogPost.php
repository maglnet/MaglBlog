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
 * @ORM\Entity(repositoryClass="MaglBlog\Repository\BlogPostRepository")
 * @ORM\Table(name="maglblog_blogpost")
 * 
 */
class BlogPost
{

	/**
	 * 
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * 
	 * @ORM\Column(type="string") 
	 */
	protected $title;

	/**
	 * 
	 * @ORM\Column(type="text", name="teaser_text")
	 */
	protected $teaserText;

	/**
	 * 
	 *  @ORM\Column(type="text")
	 */
	protected $text;

	/**
	 * 
	 *  @ORM\Column(type="datetime", name="create_date")
	 */
	protected $createDate;

	/**
	 * 
	 *  @ORM\Column(type="datetime", name="update_date")
	 */
	protected $updateDate;

	/**
	 * 
	 * @ORM\Column(type="integer", name="author_id")
	 */
	protected $authorId;

	/**
	 * 
	 * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
	 * @ORM\JoinTable(name="maglblog_blogpost_tag", 
	 *              joinColumns={@ORM\JoinColumn(name="blogpost_id", referencedColumnName = "id")}, 
	 *              inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")})
	 */
	protected $tags;

	/**
	 * 
	 * @ORM\ManyToOne(targetEntity="Category", fetch="EAGER")
	 */
	protected $category;

	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getTeaserText()
	{
		return $this->teaserText;
	}

	public function getText()
	{
		return $this->text;
	}

	public function getCreateDate()
	{
		return $this->createDate;
	}

	public function getUpdateDate()
	{
		return $this->updateDate;
	}

	public function getAuthorId()
	{
		return $this->authorId;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function setTeaserText($teaserText)
	{
		$this->teaserText = $teaserText;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function setCreateDate($create_date)
	{
		$this->createDate = $create_date;
	}

	public function setUpdateDate($update_date)
	{
		$this->updateDate = $update_date;
	}

	public function setAuthorId($author_id)
	{
		$this->authorId = $author_id;
	}

	/**
	 * 
	 * @param Collection $tags
	 */
	public function addTags(Collection $tags)
	{
		foreach ($tags as $tag) {
			$tag->setBlogPost($this);
			$this->tags->add($tag);
		}
	}

	/**
	 * 
	 * @param Collection $tags
	 */
	public function setTags(Collection $tags)
	{
		$this->tags = $tags;
	}

	/**
	 * 
	 * @param Tag $tag
	 */
	public function addTag(Tag $tag)
	{
		$tag->setBlogPost($this);
		$this->tags->add($tag);
	}

	/**
	 * 
	 * @param Collection $tags
	 */
	public function removeTags(Collection $tags)
	{
		foreach ($tags as $tag) {
			$tag->setBlogPost(null);
			$this->tags->removeElement($tag);
		}
	}

	/**
	 * 
	 * @return Collection
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * 
	 * @return Category
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * 
	 * @param Category $category
	 */
	public function setCategory(Category $category = null)
	{
		$this->category = $category;
	}

	public function getTitleForUrl()
	{
		$title = str_replace(array(' ', ','), '-', $this->getTitle());
		$title = preg_replace('/-+/', '-', $title);
		$title = trim($title, ' -');
		return urlencode($title);
	}
}
