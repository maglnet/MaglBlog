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
class BlogWidgetRecentPosts extends \Zend\View\Helper\AbstractHelper
{
	/**
	 * 
	 * @var \MaglBlog\Repository\BlogPost
	 */
	private $blogPostRepo;
	
	public function __construct(\MaglBlog\Repository\BlogPost $blogPostRepository)
	{
		$this->blogPostRepo = $blogPostRepository;
	}
	
	public function __invoke(){
		$blogPosts = $this->blogPostRepo->findRecent();
		return $this->getView()->render('magl-blog/widget/blog-post-recent-list.phtml', array('blogPosts' => $blogPosts));
	}
}
