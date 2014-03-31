<?php

/**
 * @author Jens Kohl <jens.kohl@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Repository;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of BaseFactory
 *
 * @author matthias
 */
abstract class BaseFactory implements FactoryInterface
{
	abstract public function createService(ServiceLocatorInterface $serviceLocator);
	
	public function createServiceForClass($class, ServiceLocatorInterface $serviceLocator)
	{
		$em = '\Doctrine\ORM\EntityManager';
		return $this->createServiceForClassAndEm($class, $em, $serviceLocator);
	}
	
	public function createServiceForClassAndEm($class, $em, ServiceLocatorInterface $serviceLocator) {
		$em = $serviceLocator->get($em);
		$meta = $em->getClassMetadata($class);
		$classname = $this->basenameWithDelimiter($class, '\\');
		$repositoryClass = new $classname($em, $meta);
		return $repositoryClass;
	}
	
	protected function basenameWithDelimiter($string, $delimiter) {
		$components = explode($delimiter, $string);
		$size = count($components);
		
		if ($size == 1) return $string;
		if ($size == 0) return null;
		
		if (empty($components[$size-1])) $size--;
		
		return $components[$size-1];
	}
}
