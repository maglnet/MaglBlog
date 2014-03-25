<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use MaglBlog\Entity\Tag;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of TagService
 *
 * @author matthias
 */
class TagService implements FactoryInterface
{

	/**
	 *
	 * @var EntityRepository
	 */
	private $tagRepo;
	private $tagSeparator = ',';

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('Doctrine\ORM\EntityManager');
		$this->tagRepo = $em->getRepository('\MaglBlog\Entity\Tag');
		return $this;
	}

	public function getTagCollectionFromString($tagString)
	{
		$tagCollection = new ArrayCollection();

		$tagNames = explode($this->tagSeparator, $tagString);
		foreach ($tagNames as $tagName) {
			$tagName = trim($tagName);
			if (strlen($tagName) > 0) {
				$tagNameUrl = $this->urlifyTagName($tagName);
				$tagEntity = $this->tagRepo->findOneBy(array('url_part' => $tagNameUrl));
				if (!$tagEntity) {
					$tagEntity = new Tag();
					$tagEntity->setName($tagName);
				}
				$tagEntity->setUrlPart($tagNameUrl);
				$tagCollection->add($tagEntity);
			}
		}

		return $tagCollection;
	}

	public function getTagCollectionAsString(Collection $tagCollection)
	{
		$tagString = '';
		foreach ($tagCollection as $tag) {
			$tagString .= $tag->getName() . $this->tagSeparator . ' ';
		}
		return trim($tagString, $this->tagSeparator . ' ');
	}

	public function urlifyTagName($tagName)
	{
		$urlPart = preg_replace('/[^a-z0-9]/i', '-', $tagName);
		$urlPart = preg_replace('/-{2,}/', '-', $urlPart);
		return strtolower(trim($urlPart));
	}
}
