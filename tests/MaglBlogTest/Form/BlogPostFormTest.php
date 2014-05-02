<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaglBlogTest\Form;

/**
 * Description of BlogPostFormTest
 *
 * @author matthias
 */
class BlogPostFormTest extends \PHPUnit_Framework_TestCase
{

    public function testForm()
    {
        $objectManagerMock = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $bpf = new \MaglBlog\Form\BlogPostForm($objectManagerMock);

        $this->assertInstanceOf('Zend\Form\Form', $bpf);

        $this->assertGreaterThan(0, $bpf->count());
        $this->assertTrue($bpf->has('blog_post'));
        $this->assertTrue($bpf->has('submit'));
        $this->assertTrue($bpf->has('csrf'));
    }

}
