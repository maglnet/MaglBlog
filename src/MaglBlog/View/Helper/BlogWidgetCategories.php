<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\View\Helper;

use MaglBlog\Repository\CategoryRepository;
use Zend\View\Helper\AbstractHelper;

/**
 * Description of BlogWidgetCategories
 *
 * @author matthias
 */
class BlogWidgetCategories extends AbstractHelper
{
	/**
	 * 
	 * @var CategoryRepository
	 */
	private $categoryRepo;
	
	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepo = $categoryRepository;
	}
	
	public function __invoke(){
		$categories = $this->categoryRepo->findWithActivePostsCount();
		return $this->getView()->render('magl-blog/widget/category-list.phtml', array('categories' => $categories));
	}
}
