<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\View\Helper;

use MaglBlog\Entity\BlogPost;
use Zend\View\Helper\AbstractHelper;

/**
 * Description of BlogWidgetCategories
 *
 * @author matthias
 */
class BlogUrlToPost extends AbstractHelper
{

    public function __invoke(BlogPost $blogPost)
    {
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
