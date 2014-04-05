<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Form;

use Doctrine\ORM\EntityManagerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use MaglBlog\Entity\BlogPost;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Description of BlogPostForm
 *
 * @author matthias
 */
class BlogPostFieldset extends Fieldset implements InputFilterProviderInterface
{

	protected $inputFilter;

	public function __construct(EntityManagerInterface $objectManager)
	{
		parent::__construct('blog_post');
		$this->setHydrator(new DoctrineHydrator($objectManager))
			->setObject(new BlogPost());

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		$this->add(array(
			'name' => 'title',
			'type' => 'Text',
			'options' => array(
				'label' => 'Title',
				'description' => 'insert title hereTitle',
			),
			'attributes' => array(
				'class' => 'form-control input-block-level',
			),
		));
		$this->add(array(
			'name' => 'teaserText',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'Teaser Text',
			),
			'attributes' => array(
				'class' => 'form-control input-block-level',
			),
		));
		$this->add(array(
			'name' => 'text',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'Text',
			),
			'attributes' => array(
				'class' => 'form-control input-block-level',
				'rows' => '25',
			),
		));
		$this->add(array(
			'name' => 'createDate',
			'type' => 'DateTime',
			'options' => array(
				'label' => 'Create Date',
				'format' => 'Y-m-d H:i:s',
			),
			'attributes' => array(
				'class' => 'form-control',
				'min' => '2013-01-01 00:00:00',
				'max' => '2020-01-01 00:00:00',
				'step' => 'any',
			),
		));
		$this->add(array(
			'name' => 'updateDate',
			'type' => 'DateTime',
			'options' => array(
				'label' => 'Update Date',
				'format' => 'Y-m-d H:i:s',
			),
			'attributes' => array(
				'class' => 'form-control',
				'min' => '2013-01-01 00:00:00',
				'max' => '2020-01-01 00:00:00',
				'step' => 'any',
			),
		));
		$this->add(array(
			'name' => 'authorId',
			'type' => 'Text',
			'options' => array(
				'label' => 'Author Id',
			),
			'attributes' => array(
				'class' => 'form-control',
			),
		));

		$this->add(array(
			'name' => 'category',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'empty_option' => 'Select Category',
				'label' => "Category",
				'object_manager' => $objectManager,
				'target_class' => 'MaglBlog\Entity\Category',
				'property' => 'name',
			),
			'attributes' => array(
			)
		));

		$this->add(array(
			'name' => 'tags-holder',
			'type' => 'Text',
			'options' => array(
				'label' => 'Tags',
				'description' => 'insert comma separated tags',
			),
			'attributes' => array(
				'class' => 'form-control input-block-level',
			),
		));
	}

	public function getInputFilterSpecification()
	{
		return array(
			'id' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
				),
			),
			'title' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 128,
						),
					),
				),
			),
			'teaserText' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 320,
						),
					),
				),
			),
			'text' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 50,
						//'max'      => 320,
						),
					),
				),
			),
			'createDate' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			),
			'updateDate' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			),
			'authorId' => array(
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			),
			'category' => array(
				'required' => false,
				'allow_empty' => true,
			),
			'tags-holder' => array(
				'required' => false,
				'allow_empty' => true,
			),
		);
	}
}
