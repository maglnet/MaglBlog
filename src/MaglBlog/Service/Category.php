<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Service;

use DoctrineORMModule\Options\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

/**
 * Description of Category
 *
 * @author matthias
 */
class Category implements FactoryInterface
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

	/**
	 * 
	 * @return EntityManager
	 */
	private function getEntityManager()
	{
		return $this->em;
	}

	public function getListForWidget()
	{
		$categories = $this->categoryRepo->findBy(array(), array('name' => 'ASC'));
		return $categories;
	}
}
