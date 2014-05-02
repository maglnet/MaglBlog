<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of Category
 *
 * @author matthias
 */
class CategoryService implements FactoryInterface
{

    /**
     *
     * @var \MaglBlog\Repository\Category
     */
    private $categoryRepo;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->categoryRepo = $serviceLocator->get('MaglBlog\CategoryRepository');
        return $this;
    }

    public function getListForWidget()
    {
        $categories = $this->categoryRepo->findBy(array(), array('name' => 'ASC'));
        return $categories;
    }
}
