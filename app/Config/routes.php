<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

	Router::connect('/', array('controller' => 'homes', 'action' => 'index'));
	Router::connect('/admin', array('controller' => 'homes', 'action' => 'home', 'admin' => true));
	Router::connect('/user', array('controller' => 'users', 'action' => 'changepassword', 'user' => true));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	Router::connect('/opauth-complete/*', array('controller' => 'users', 'action' => 'opauth_complete'));
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/categories', array('controller' => 'categories', 'action' => 'index'));
	Router::connect('/products', array('controller' => 'categories', 'action' => 'index'));
	Router::connect(
    '/products/details/:title-:id.html',
    array(
        'controller' => 'products',
        'action' => 'details'
    ),
    array(
        'pass' => array('id'),
        'id' => '[0-9]+'
    )
	);
	Router::connect( '/News/detail/:id-:slug.html', array(
		'controller' => 'News',
		'action' => 'detail'), 
		array( 'pass' => 
			array('id', 'slug'),
			"id"=>"[0-9]+",
		)
	 );
	Router::connect( '/News/:id-:slug.html', array(
		'controller' => 'News',
		'action' => 'index'), 
		array( 'pass' => 
			array('id', 'slug'),
			"id"=>"[0-9]+",
		)
	 ); 
	Router::connect( '/Blogs/:id-:slug.html', array(
		'controller' => 'News',
		'action' => 'blog'), 
		array( 'pass' => 
			array('id', 'slug'),
			"id"=>"[0-9]+",
		)
	 ); 

	Router::connect(
    '/:controller',
    array(
        'controller' => 'controller',
        'action' => 'index'
    )
	);
/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Add REST support
 * 
 */
	Router::mapResources('apis');
//	Router::parseExtensions();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

