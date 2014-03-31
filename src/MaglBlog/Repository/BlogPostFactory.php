<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Repository;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of BlogPostFactory
 *
 * @author matthias
 */
class BlogPostFactory extends BaseFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return $this->createServiceForClass('\MaglBlog\Entity\BlogPost', $serviceLocator);
	}
}
