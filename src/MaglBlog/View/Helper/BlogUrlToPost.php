<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\View\Helper;

/**
 * Description of BlogWidgetCategories
 *
 * @author matthias
 */
class BlogUrlToPost extends \Zend\View\Helper\AbstractHelper
{
	
	public function __invoke(\MaglBlog\Entity\BlogPost $blogPost){
		$url = $this
			->getView()
			->url('maglblog/post', 
				array(
					'id' => $blogPost->getId(),
					'title' => $blogPost->getTitleForUrl()
				)
			);
		return $url;
	}
}
