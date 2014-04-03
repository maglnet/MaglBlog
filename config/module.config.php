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
	),
	'controllers' => array(
		'factories' => array(
			'MaglBlog\Controller\BlogAdmin' => 'MaglBlog\Controller\BlogAdminController',
			'MaglBlog\Controller\Blog' => 'MaglBlog\Controller\BlogController',
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
		)
	),
	'router' => array(
		'routes' => array(
			'maglblog' => array(
				'type' => 'literal',
				'options' => array(
					'route' => '/blog',
					'defaults' => array(
						'controller' => 'Magl\Blog\Controller\Blog',
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
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'controller' => 'Magl\Blog\Controller\Blog',
								'action' => 'category',
							),
						),
					),
					'post' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/post[/:id][/:title]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'controller' => 'Magl\Blog\Controller\Blog',
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
								'controller' => 'Magl\Blog\Controller\Blog',
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
							'route' => '/blog[/][:action][/:id]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'controller' => 'Magl\Blog\Controller\BlogAdmin',
								'action' => 'index',
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
