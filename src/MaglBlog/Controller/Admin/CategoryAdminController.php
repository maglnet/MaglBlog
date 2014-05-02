<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglBlog\Controller\Admin;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use MaglBlog\Form\CategoryForm;
use MaglBlog\Entity\Category;
use Zend\View\Model\ViewModel;

class CategoryAdminController extends AbstractBlogAdminController
{

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $category = new Category();
        } else {
            $category = $this->getObjectManager()->getRepository('\MaglBlog\Entity\Category')->findOneBy(array('id' => $this->params('id')));
        }

        $form = new CategoryForm($this->getObjectManager());
        $form->setHydrator(new DoctrineObject($this->getObjectManager(), true));
        $form->bind($category);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getObjectManager()->persist($category);
                $this->getObjectManager()->flush();

                // Redirect to list
                return $this->redirect()->toRoute('zfcadmin/maglblog/category', array('action' => 'list'));
            }
        }

        $editView = new ViewModel(array(
            'id' => $id,
            'form' => $form,
        ));
        $editView->setTemplate('magl-blog/blog-admin/category/edit');
        return $this->getAdminView($editView);
    }

    public function listAction()
    {
        /* @var $categoryRepo \MaglBlog\Repository\CategoryRepository */
        $categoryRepo = $this->sm->get('MaglBlog\CategoryRepository');
        $categories = $categoryRepo->findAll();

        $listView = new ViewModel(array(
            'categories' => $categories,
        ));
        $listView->setTemplate('magl-blog/blog-admin/category/list');
        return $this->getAdminView($listView);
    }
}
