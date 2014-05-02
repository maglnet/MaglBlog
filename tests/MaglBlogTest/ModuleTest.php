<?php

namespace MaglBlogTest;

use MaglBlog\Module;
use MaglBlogTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\View\Http\ViewManager;
use Zend\ServiceManager\ServiceManager;

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

    /**
     *
     * @var ServiceManager
     */
    private $sm;

    /**
     *
     * @var ViewManager
     */
    private $viewHelper;

    public function setUp()
    {
        $this->instance = new Module();
        $this->sm = Bootstrap::getServiceManager();
        $this->viewHelper = $this->sm->get('ViewHelperManager');
    }

    public function testInstance()
    {
        $this->assertInstanceOf('MaglBlog\Module', $this->instance);
    }

    public function testGetConfig()
    {
        $config = $this->instance->getConfig();

        $this->assertTrue(is_array($config));
    }

    public function testGetAutoloaderConfig()
    {
        $config = $this->instance->getAutoloaderConfig();

        $this->assertTrue(array_key_exists('MaglBlog', $config['Zend\Loader\StandardAutoloader']['namespaces']));
    }

    public function testGetViewHelperConfig()
    {
        $config = $this->instance->getViewHelperConfig();

        $this->assertTrue(array_key_exists('BlogWidgetCategories', $config['factories']));
        $this->assertTrue(array_key_exists('BlogWidgetTagCloud', $config['factories']));
        $this->assertTrue(array_key_exists('BlogWidgetRecentPosts', $config['factories']));

        $this->assertTrue(array_key_exists('BlogUrlToPost', $config['factories']));
    }

    public function testGetModuleDependencies()
    {
        $config = $this->instance->getModuleDependencies();

        $this->assertTrue(is_array($config));

        $this->assertEquals(3, count($config));

        $this->assertTrue(in_array('ZfcAdmin', $config));
        $this->assertTrue(in_array('DoctrineModule', $config));
        $this->assertTrue(in_array('DoctrineORMModule', $config));

    }

    public function testGetViewHelperWidgetCategories()
    {
        $widget = $this->viewHelper->get('BlogWidgetCategories');
        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $widget);
        $this->assertInstanceOf('MaglBlog\View\Helper\BlogWidgetCategories', $widget);
    }

    public function testGetViewHelperWidgetTagCloud()
    {
        $widget = $this->viewHelper->get('BlogWidgetTagCloud');
        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $widget);
        $this->assertInstanceOf('MaglBlog\View\Helper\BlogWidgetTagCloud', $widget);
    }

    public function testGetViewHelperWidgetRecentPosts()
    {
        $widget = $this->viewHelper->get('BlogWidgetRecentPosts');
        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $widget);
        $this->assertInstanceOf('MaglBlog\View\Helper\BlogWidgetRecentPosts', $widget);
    }

    public function testGetViewHelperBlogUrlToPost()
    {
        $widget = $this->viewHelper->get('BlogUrlToPost');
        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $widget);
        $this->assertInstanceOf('MaglBlog\View\Helper\BlogUrlToPost', $widget);
    }

}
