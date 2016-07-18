<?php
/**
 * Pages routes configuration
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

Router::connect('/test_menus/:controller/:action/*', array(
	'plugin' => 'test_menus'
));
Router::connect('/test_menus/:controller/:action', array(
	'plugin' => 'test_menus'
));
