<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaglBlogTest\Options;

/**
 * Description of MaglBlogOptionsTest
 *
 * @author matthias
 */
class MaglBlogOptionsTest extends \PHPUnit_Framework_TestCase
{

	public function testShippedConfigOK()
	{

		$sm = \MaglBlogTest\Bootstrap::getServiceManager();
		$config = $sm->get('config');

		$blogOptions = new \MaglBlog\Options\MaglBlogOptions($config['magl_blog']);

		$this->assertTrue(is_array($blogOptions->getTagCloud()));
	}

	public function testTagCloudWidgetNoArrayGiven()
	{
		$sm = \MaglBlogTest\Bootstrap::getServiceManager();

		$blogOptions = new \MaglBlog\Options\MaglBlogOptions();

		$this->setExpectedException('InvalidArgumentException');

		$blogOptions->setTagCloud('no array');
	}

	public function testTagCloudWidgetMissingTagDecorator()
	{
		$sm = \MaglBlogTest\Bootstrap::getServiceManager();

		$blogOptions = new \MaglBlog\Options\MaglBlogOptions();

		$this->setExpectedException('InvalidArgumentException');

		$blogOptions->setTagCloud(array(
			'cloudDecorator' => array(
				'foo' => 'bar',
			)
		));
	}

	public function testTagCloudWidgetMissingCloudDecorator()
	{
		$sm = \MaglBlogTest\Bootstrap::getServiceManager();

		$blogOptions = new \MaglBlog\Options\MaglBlogOptions();

		$this->setExpectedException('InvalidArgumentException');

		$blogOptions->setTagCloud(array(
			'tagDecorator' => array(
				'foo' => 'bar',
			)
		));
	}

	public function testSetGetRecentPostsNum()
	{
		$sm = \MaglBlogTest\Bootstrap::getServiceManager();

		$postsNum = 5;

		$blogOptions = new \MaglBlog\Options\MaglBlogOptions();

		$blogOptions->setRecentPostsNum($postsNum);
		$this->assertEquals($postsNum, $blogOptions->getRecentPostsNum());
	}
}
