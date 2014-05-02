<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Navigation;

class AdminNavigationFactory extends \Zend\Navigation\Service\DefaultNavigationFactory
{
    protected function getName()
    {
        return 'magl_blog_admin';
    }
}
