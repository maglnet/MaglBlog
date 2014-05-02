<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog;

use MaglBlog\View\Helper\BlogUrlToPost;
use MaglBlog\View\Helper\BlogWidgetArchive;
use MaglBlog\View\Helper\BlogWidgetCategories;
use MaglBlog\View\Helper\BlogWidgetRecentPosts;
use MaglBlog\View\Helper\BlogWidgetTagCloud;

/**
 * Description of Module
 *
 * @author matthias
 */
class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getModuleDependencies()
    {
        return array(
            'DoctrineModule',
            'DoctrineORMModule',
            'ZfcAdmin',
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'BlogUrlToPost' => function ($sl) {
                    return new BlogUrlToPost();
                },
                'BlogWidgetTagCloud' => function ($sl) {
                    $tagRepository = $sl->getServiceLocator()->get('MaglBlog\TagRepository');
                    $blogOptions = $sl->getServiceLocator()->get('MaglBlog\BlogOptions');

                    return new BlogWidgetTagCloud($tagRepository, $blogOptions);
                },
                'BlogWidgetCategories' => function ($sl) {
                    $categoryRepository = $sl->getServiceLocator()->get('MaglBlog\CategoryRepository');

                    return new BlogWidgetCategories($categoryRepository);
                },
                'BlogWidgetRecentPosts' => function ($sl) {
                    $blogPostRepository = $sl->getServiceLocator()->get('MaglBlog\BlogPostRepository');
                    $blogOptions = $sl->getServiceLocator()->get('MaglBlog\BlogOptions');

                    return new BlogWidgetRecentPosts($blogPostRepository, $blogOptions);
                },
                'BlogWidgetArchive' => function ($sl) {
                    $blogPostRepository = $sl->getServiceLocator()->get('MaglBlog\BlogPostRepository');
                    $blogOptions = $sl->getServiceLocator()->get('MaglBlog\BlogOptions');

                    return new BlogWidgetArchive($blogPostRepository, $blogOptions);
                },
            ),
        );
    }
}
