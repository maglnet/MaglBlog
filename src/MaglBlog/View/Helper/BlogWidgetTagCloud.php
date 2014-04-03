<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\View\Helper;

use MaglBlog\Options\MaglBlogOptions;
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
	
	/**
	 *
	 * @var array
	 */
	private $tagCloudOptions;

	public function __construct(TagRepository $tagRepository, MaglBlogOptions $blogOptions)
	{
		$this->tagRepo = $tagRepository;
		$this->tagCloudOptions = $blogOptions->getTagCloud();
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
			'cloudDecorator' => $this->tagCloudOptions['cloudDecorator'],
			'tagDecorator' => $this->tagCloudOptions['tagDecorator'],
			'tags' => $tagList,
		));

		return $this->getView()->render('magl-blog/widget/tag-cloud.phtml', array('tagCloud' => $tagCloud));
	}
}
