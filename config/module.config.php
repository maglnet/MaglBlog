<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
return array(
	'magl_blog' => array(
		'recent_posts_num' => 5,
		'tag_cloud' => array(
			'cloudDecorator' => array(
				'decorator' => 'htmlcloud',
				'options'   => array(
					//'separator' => "\n\n",
					'htmlTags'  => array(
						'div' => array(
							'class' => 'maglblog-tag-cloud',
						),
					),
				),
			),
			'tagDecorator' => array(
				'decorator' => 'htmltag',
				'options'   => array(
					'minFontSize' => '10',
					'maxFontSize' => '26',
					//'classList' => array('tag1','tag2','tag3','tag4','tag5','tag6','tag7','tag8','tag9','tag10'),
					'htmlTags'    => array(
						'span' => array(),
					),
				),
			),
		)
	),
	'navigation' => array(
		'default' => array(
			'magl_blog' => array(
				'label' => 'Blog',
				'route' => 'maglblog',
			),
		),
		'admin' => array(
			'magl_blog_admin' => array(
				'label' => 'Blog Admin',
				'route' => 'zfcadmin/maglblog',
			),
		),
		'magl_blog_admin' => array(
			array(
				'label' => 'Posts',
				'route' => 'zfcadmin/maglblog/post',
				'pages' => array(
					array(
						'label' => 'List Posts',
						'route' => 'zfcadmin/maglblog/post',
						'params' => array('action' => 'list'),
					),
					array(
						'label' => 'Create Post',
						'route' => 'zfcadmin/maglblog/post',
						'params' => array('action' => 'edit'),
					),
				),
			),
			array(
				'label' => 'Categories',
				'route' => 'zfcadmin/maglblog/category',
				'params' => array('action' => 'list'),
				'pages' => array(
					array(
						'label' => 'List Categories',
						'route' => 'zfcadmin/maglblog/category',
						'params' => array('action' => 'list'),
					),
					array(
						'label' => 'Create Category',
						'route' => 'zfcadmin/maglblog/category',
						'params' => array('action' => 'edit'),
					),
				),
			),
		),
	),
	'controllers' => array(
		'factories' => array(
			'MaglBlog\Controller\Blog' => 'MaglBlog\Controller\BlogController',
			
			'MaglBlog\Controller\CategoryAdmin' => 'MaglBlog\Controller\Admin\CategoryAdminController',
			'MaglBlog\Controller\BlogPostAdmin' => 'MaglBlog\Controller\Admin\BlogPostAdminController',
		),
	),
	'service_manager' => array(
		'factories' => array(
			'MaglBlog\BlogOptions' => 'MaglBlog\Options\MaglBlogOptionsFactory',
			'MaglBlog\TagService' => 'MaglBlog\Service\TagService',
			'MaglBlog\CategoryService' => 'MaglBlog\Service\CategoryService',
			'MaglBlog\BlogPostService' => 'MaglBlog\Service\BlogPostService',
			'MaglBlog\TagRepository' => 'MaglBlog\Repository\TagFactory',
			'MaglBlog\CategoryRepository' => 'MaglBlog\Repository\CategoryFactory',
			'MaglBlog\BlogPostRepository' => 'MaglBlog\Repository\BlogPostFactory',
			'magl_blog_admin_navigation' => 'MaglBlog\Navigation\AdminNavigationFactory',
		)
	),
	'router' => array(
		'routes' => array(
			'maglblog' => array(
				'type' => 'literal',
				'options' => array(
					'route' => '/blog',
					'defaults' => array(
						'controller' => 'MaglBlog\Controller\Blog',
						'action' => 'list',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'category' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/category[/:id][/:title]',
							'constraints' => array(
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'controller' => 'MaglBlog\Controller\Blog',
								'action' => 'category',
							),
						),
					),
					'post' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/post[/:id][/:title]',
							'constraints' => array(
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'controller' => 'MaglBlog\Controller\Blog',
								'action' => 'post',
							),
						),
					),
					'tag' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/tag/:tagUrlPart',
							'constraints' => array(
								'tagUrlPart' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
								'controller' => 'MaglBlog\Controller\Blog',
								'action' => 'tag',
							),
						),
					),
				),
			),
			'zfcadmin' => array(
				'child_routes' => array(
					'maglblog' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/blog[/]',
							'defaults' => array(
								'controller' => 'MaglBlog\Controller\BlogPostAdmin',
								'action' => 'list',
							),
						),
						'may_terminate' => true,
						'child_routes' => array(
							'category' => array(
								'type' => 'segment',
								'options' => array(
									'route' => 'category[/][:action][/:id]',
									'defaults' => array(
										'controller' => 'MaglBlog\Controller\CategoryAdmin',
										'action' => 'edit',
									),
								),
								'may_terminate' => true,
							),
							'post' => array(
								'type' => 'segment',
								'options' => array(
									'route' => 'post[/][:action][/:id]',
									'defaults' => array(
										'controller' => 'MaglBlog\Controller\BlogPostAdmin',
										'action' => 'list',
									),
								),
								'may_terminate' => true,
							),
						),
					),
				),
			),
		),
	),
	'view_manager' => array(
//		'template_map' => array(
//		//	'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
//		),
		'template_path_stack' => array(
			'blog' => __DIR__ . '/../view',
		),
	),
	'doctrine' => array(
		'driver' => array(
			// defines an annotation driver with two paths, and names it `my_annotation_driver`
			'magl_blog_annotation_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
					__DIR__ . '/../src/MaglBlog/Entity',
				),
			),
			// default metadata driver, aggregates all other drivers into a single one.
			// Override `orm_default` only if you know what you're doing
			'orm_default' => array(
				'drivers' => array(
					// register `my_annotation_driver` for any entity under namespace `My\Namespace`
					'MaglBlog\Entity' => 'magl_blog_annotation_driver'
				)
			)
		)
	),
);
