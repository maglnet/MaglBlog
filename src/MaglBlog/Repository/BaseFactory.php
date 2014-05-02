<?php

/**
 * @author Jens Kohl <jens.kohl@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Repository;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * BaseFactory acts as collection of reusable init methods
 * for each of the concrete factory classes
 *
 * @author Jens Kohl
 */
abstract class BaseFactory implements FactoryInterface
{
    abstract public function createService(ServiceLocatorInterface $serviceLocator);

    /**
     * @param string $class Classname with Namespace
     * @param ServiceLocatorInterface $serviceLocator A ServiceLocator
     */
    public function createServiceForClass($class, ServiceLocatorInterface $serviceLocator)
    {
        $em = '\Doctrine\ORM\EntityManager';
        return $this->createServiceForClassAndEm($class, $em, $serviceLocator);
    }

    /**
     * @param string $class Classname with Namespace
     * @param string $em An Entity Model
     * @param ServiceLocatorInterface $serviceLocator A ServiceLocator
     */
    public function createServiceForClassAndEm($class, $em, ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get($em);
        $meta = $em->getClassMetadata($class);
        $classname = $this->basenameWithDelimiter($class, '\\');
        $classname = __NAMESPACE__ . '\\' . $classname.'Repository';
        $repositoryClass = new $classname($em, $meta);
        return $repositoryClass;
    }

    /**
     * Returns trailing name component of a string with a given delimiter
     * @param string $string A string
     * @param string $delimiter A delimiter, by default the backslash as used in PHP namespaces
     */
    protected function basenameWithDelimiter($string, $delimiter = '\\')
    {
        $components = explode($delimiter, $string);
        $size = count($components);

        if ($size == 1) return $string;
        if ($size == 0) return null;

        if (empty($components[$size-1])) $size--;

        return $components[$size-1];
    }
}
