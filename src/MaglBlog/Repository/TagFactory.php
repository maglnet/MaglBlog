<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Repository;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of TagFactory
 *
 * @author matthias
 */
class TagFactory extends BaseFactory
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return $this->createServiceForClass('\MaglBlog\Entity\Tag', $serviceLocator);
	}
}
