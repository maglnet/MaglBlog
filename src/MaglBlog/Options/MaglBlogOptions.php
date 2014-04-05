<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Options;

use InvalidArgumentException;
use Zend\Stdlib\AbstractOptions;

class MaglBlogOptions extends AbstractOptions
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**
     * @var array
     */
    protected $tagCloud;
	
    /**
     * @var int
     */
    protected $recentPostsNum = 5;

	public function getTagCloud()
	{
		return $this->tagCloud;
	}

	public function setTagCloud($tagCloud)
	{
		if (!is_array($tagCloud)) {
            throw new InvalidArgumentException(sprintf(
                'tag_cloud config must be an array, %s given',
                gettype($tagCloud)
            ));
        }
        if (!isset($tagCloud['cloudDecorator'])
         || !isset($tagCloud['tagDecorator']))
        {
            throw new InvalidArgumentException(sprintf(
                'tag_cloud config must contain keys "cloudDecorator" and "tagDecorator", "%s" given',
                implode('", "', array_keys($tagCloud))
            ));
        }

		$this->tagCloud = $tagCloud;
        return $this;
	}
	
	public function getRecentPostsNum()
	{
		return $this->recentPostsNum;
	}

	public function setRecentPostsNum($recentPostsNum)
	{
		$this->recentPostsNum = $recentPostsNum;
	}


	


}