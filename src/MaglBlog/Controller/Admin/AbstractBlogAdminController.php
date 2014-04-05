<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Controller\Admin;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

abstract class AbstractBlogAdminController extends AbstractActionController implements FactoryInterface
{

	/**
	 *
	 * @var ObjectManager
	 */
	protected $objectManager;

	/**
	 *
	 * @var ServiceManager
	 */
	protected $sm;

	protected function getAdminView($contentView)
	{
		$blogAdminView = new ViewModel();
		$blogAdminView->setTemplate('magl-blog/blog-admin/admin-layout');
		$blogAdminView->addChild($contentView, 'content');
		return $blogAdminView;
	}

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$this->objectManager = $serviceLocator->getServiceLocator()
			->get('Doctrine\ORM\EntityManager');
		$this->sm = $serviceLocator->getServiceLocator();
		return $this;
	}

	/**
	 * 
	 * @return ObjectManager
	 */
	protected function getObjectManager()
	{
		return $this->objectManager;
	}
}
