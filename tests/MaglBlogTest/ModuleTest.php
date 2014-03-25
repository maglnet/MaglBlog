<?php

namespace MaglBlogTest;

use MaglBlog\Module;
use PHPUnit_Framework_TestCase;
use Zend\View\HelperPluginManager;

/**
 * Description of ModuleTest
 *
 * @author matthias
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{

	/**
	 *
	 * @var Module
	 */
	private $instance;

	public function setUp()
	{
		$this->instance = new Module();
	}

	public function testInstance()
	{
		$this->assertInstanceOf('MaglBlog\Module', $this->instance);
	}

	public function testGetViewHelperConfig()
	{
		$config = $this->instance->getViewHelperConfig();

		$this->assertTrue(array_key_exists('BlogWidgetCategories', $config['factories']));
		$this->assertTrue(array_key_exists('BlogWidgetTagCloud', $config['factories']));
		$this->assertTrue(array_key_exists('BlogWidgetRecentPosts', $config['factories']));
		
		$this->assertTrue(array_key_exists('BlogUrlToPost', $config['factories']));
	}

	public function testGetViewHelper()
	{
		$serviceManager = Bootstrap::getServiceManager();

		/* @var $view HelperPluginManager */
		$view = $serviceManager->get('ViewHelperManager');

		$blogWidgetCategory = $view->get('BlogWidgetCategories');
		$this->assertInstanceOf('Zend\View\Helper\HelperInterface', $blogWidgetCategory);
		$this->assertInstanceOf('MaglBlog\View\Helper\BlogWidgetCategories', $blogWidgetCategory);
	}

}
