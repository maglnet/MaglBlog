<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Repository;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of CategoryFactory
 *
 * @author matthias
 */
class CategoryFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('Doctrine\ORM\EntityManager');
		$categoryRepo = $em->getRepository('\MaglBlog\Entity\Category');
		return $categoryRepo;
	}
}
