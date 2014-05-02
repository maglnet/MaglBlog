<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\View\Helper;

use MaglBlog\Options\MaglBlogOptions;
use MaglBlog\Repository\BlogPostRepository;
use Zend\View\Helper\AbstractHelper;

class BlogWidgetArchive extends AbstractHelper
{
 	/**
	 * 
	 * @var BlogPostRepository
	 */
	private $blogPostRepo;
	
	/**
	 * 
	 * @var MaglBlogOptions
	 */
	private $blogOptions;
	
	public function __construct(BlogPostRepository $blogPostRepository, MaglBlogOptions $blogOptions)
	{
		$this->blogPostRepo = $blogPostRepository;
		$this->blogOptions = $blogOptions;
	}
	
	public function __invoke(){
		$archiveDateInfo = $this->blogPostRepo->getArchiveDateInfo($this->blogOptions->getArchiveWidgetLimit());
		return $this->getView()->render('magl-blog/widget/archive.phtml', array('archiveDateInfo' => $archiveDateInfo));
	}
}
