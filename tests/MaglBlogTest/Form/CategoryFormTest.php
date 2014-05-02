<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaglBlogTest\Form;

/**
 * Description of CategoryFormTest
 *
 * @author matthias
 */
class CategoryFormTest extends \PHPUnit_Framework_TestCase
{

    public function testForm()
    {
        $objectManagerMock = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $catForm = new \MaglBlog\Form\CategoryForm($objectManagerMock);

        $this->assertInstanceOf('Zend\Form\Form', $catForm);

        $this->assertGreaterThan(0, $catForm->count());
        $this->assertTrue($catForm->has('id'));
        $this->assertTrue($catForm->has('name'));
        $this->assertTrue($catForm->has('submit'));
        $this->assertTrue($catForm->has('csrf'));
    }

}
