<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaglBlogTest\Form;

/**
 * Description of BlogPostFieldsetTest
 *
 * @author matthias
 */
class BlogPostFieldsetTest extends \PHPUnit_Framework_TestCase
{

    public function testFieldset()
    {
        $objectManagerMock = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $bpfs = new \MaglBlog\Form\BlogPostFieldset($objectManagerMock);

        $this->assertInstanceOf('Zend\Form\Fieldset', $bpfs);

        $this->assertGreaterThan(0, $bpfs->count());
        $this->assertTrue($bpfs->has('id'));
        $this->assertTrue($bpfs->has('title'));
        $this->assertTrue($bpfs->has('teaserText'));
        $this->assertTrue($bpfs->has('text'));
        $this->assertTrue($bpfs->has('createDate'));
        $this->assertTrue($bpfs->has('updateDate'));
        $this->assertTrue($bpfs->has('authorId'));
        $this->assertTrue($bpfs->has('category'));
        $this->assertTrue($bpfs->has('tags-holder'));

    }

    public function testProvidesValidInputFilter()
    {
        $objectManagerMock = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $bpfs = new \MaglBlog\Form\BlogPostFieldset($objectManagerMock);

        $this->assertInstanceOf('Zend\InputFilter\InputFilterProviderInterface', $bpfs);

        $inputFilterSpec = $bpfs->getInputFilterSpecification();

        $this->assertNotEmpty($inputFilterSpec);


        $factory = new \Zend\InputFilter\Factory();
        $inputFilter = $factory->createInputFilter($inputFilterSpec);

        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('title'));
        $this->assertTrue($inputFilter->has('teaserText'));
        $this->assertTrue($inputFilter->has('text'));
        $this->assertTrue($inputFilter->has('createDate'));
        $this->assertTrue($inputFilter->has('updateDate'));
        $this->assertTrue($inputFilter->has('authorId'));
        $this->assertTrue($inputFilter->has('category'));
        $this->assertTrue($inputFilter->has('tags-holder'));

    }

}
