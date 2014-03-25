<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\View\Helper;

use MaglBlog\Repository\BlogPostRepository;
use Zend\View\Helper\AbstractHelper;

/**
 * Description of BlogWidgetCategories
 *
 * @author matthias
 */
class BlogWidgetRecentPosts extends AbstractHelper
{
	/**
	 * 
	 * @var BlogPostRepository
	 */
	private $blogPostRepo;
	
	public function __construct(BlogPostRepository $blogPostRepository)
	{
		$this->blogPostRepo = $blogPostRepository;
	}
	
	public function __invoke(){
		$blogPosts = $this->blogPostRepo->findRecent();
		return $this->getView()->render('magl-blog/widget/blog-post-recent-list.phtml', array('blogPosts' => $blogPosts));
	}
}
