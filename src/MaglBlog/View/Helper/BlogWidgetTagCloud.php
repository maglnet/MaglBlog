<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\View\Helper;

use MaglBlog\Repository\TagRepository;
use Zend\Tag\Cloud;
use Zend\View\Helper\AbstractHelper;

class BlogWidgetTagCloud extends AbstractHelper
{

	/**
	 * 
	 * @var TagRepository
	 */
	private $tagRepo;

	public function __construct(TagRepository $tagRepository)
	{
		$this->tagRepo = $tagRepository;
	}

	public function __invoke()
	{
		$tags = $this->tagRepo->findWithPostCount();

		$tagList = array();
		foreach ($tags as $tag) {
			$tagList[] = array(
				'title' => $tag['tag']->getName(),
				'weight' => $tag['postCount'],
				'params' => array(
				'url' => $this->getView()->url('maglblog/tag', array('tagUrlPart' => $tag['tag']->getUrlPart()))
				)
			);
		}
		$tagCloud = new Cloud(array(
			'tags' => $tagList
		));

		return $this->getView()->render('magl-blog/widget/tag-cloud.phtml', array('tagCloud' => $tagCloud));
	}
}
