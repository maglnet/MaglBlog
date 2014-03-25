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
class BlogWidgetCategories extends \Zend\View\Helper\AbstractHelper
{
	/**
	 * 
	 * @var \MaglBlog\Repository\Category
	 */
	private $categoryRepo;
	
	public function __construct(\MaglBlog\Repository\Category $categoryRepository)
	{
		$this->categoryRepo = $categoryRepository;
	}
	
	public function __invoke(){
		$categories = $this->categoryRepo->findWithActivePostsCount();
		return $this->getView()->render('magl-blog/widget/category-list.phtml', array('categories' => $categories));
	}
}
