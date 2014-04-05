<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Controller\Admin;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Exception;
use MaglBlog\Entity\BlogPost;
use MaglBlog\Form\BlogPostForm;
use Zend\View\Model\ViewModel;

class BlogPostAdminController extends AbstractBlogAdminController
{

	public function listAction()
	{
		$blogPostRepo = $this->getObjectManager()->getRepository('\MaglBlog\Entity\BlogPost');
		$blogPosts = $blogPostRepo->findBy(array(), array('createDate' => 'DESC'));

		$listView = new ViewModel(array(
			'blogPosts' => $blogPosts,
		));
		$listView->setTemplate('magl-blog/blog-admin/post/list');
		return $this->getAdminView($listView);
	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$blogPost = new BlogPost();
		} else {
			try {
				$blogPost = $this->getObjectManager()->getRepository('\MaglBlog\Entity\BlogPost')->findOneBy(array('id' => $this->params('id')));
			} catch (Exception $ex) {
				return $this->redirect()->toRoute('zfcadmin/maglblog');
			}
		}

		$form = new BlogPostForm($this->getObjectManager());
		$form->setHydrator(new DoctrineObject($this->getObjectManager(), get_class($blogPost)));
		$form->bind($blogPost);
		$form->get('submit')->setAttribute('value', 'Edit');

		$tagString = $this->sm->get('MaglBlog\TagService')->getTagCollectionAsString($blogPost->getTags());

		$blogPostFieldset = $form->get('blog_post');
		$blogPostFieldset->get('tags-holder')->setValue($tagString);

		$request = $this->getRequest();
		if ($request->isPost()) {
			//$form->setInputFilter($blogPost->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$blogPostFieldset = $form->get('blog_post');
				$tagsString = $blogPostFieldset->get('tags-holder')->getValue();

				$tagCollection = $this->sm->get('MaglBlog\TagService')->getTagCollectionFromString($tagsString);
				$blogPost->setTags($tagCollection);

				$this->getObjectManager()->persist($blogPost);
				$this->getObjectManager()->flush();

				// Redirect to list
				return $this->redirect()->toRoute('zfcadmin/maglblog');
			}
		}

		$editView = new ViewModel(array(
			'id' => $id,
			'form' => $form,
		));
		$editView->setTemplate('magl-blog/blog-admin/post/edit');
		return $this->getAdminView($editView);
	}
}
