<?php
/**
 * Menusプラグイン用PageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PageFixture', 'Pages.Test/Fixture');

/**
 * Menusプラグイン用PageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Fixture
 */
class Page4menuFixture extends PageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Page';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'pages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'room_id' => '1',
			'parent_id' => null,
			'lft' => '1',
			'rght' => '2',
			'permalink' => '',
			'slug' => null,
			'is_published' => '1',
			'from' => null,
			'to' => null,
			'is_container_fluid' => '1',
		),
		//page.permalink=page_1
		array(
			'id' => '2',
			'room_id' => '1',
			'parent_id' => null,
			'lft' => '3',
			'rght' => '6',
			'permalink' => 'page_1',
			'slug' => 'page_1',
			'is_published' => '1',
			'from' => null,
			'to' => null,
			'is_container_fluid' => '1',
		),
		//page.permalink=page_2
		array(
			'id' => '3',
			'room_id' => '1',
			'parent_id' => null,
			'lft' => '7',
			'rght' => '8',
			'permalink' => 'page_2',
			'slug' => 'page_2',
			'is_published' => '1',
			'from' => null,
			'to' => null,
			'is_container_fluid' => '1',
		),
		//page.permalink=page_1/page_3
		array(
			'id' => '4',
			'room_id' => '1',
			'parent_id' => '2',
			'lft' => '4',
			'rght' => '5',
			'permalink' => 'page_3',
			'slug' => 'page_3',
			'is_published' => '1',
			'from' => null,
			'to' => null,
			'is_container_fluid' => '1',
		),
		//別ルーム(room_id=4)
		array(
			'id' => '5',
			'room_id' => '4',
			'parent_id' => null,
			'lft' => '9',
			'rght' => '10',
			'permalink' => 'page_4',
			'slug' => 'page_4',
			'is_published' => '1',
			'from' => null,
			'to' => null,
			'is_container_fluid' => '1',
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '6',
			'room_id' => '5',
			'parent_id' => null,
			'lft' => '11',
			'rght' => '12',
			'permalink' => 'page_5',
			'slug' => 'page_5',
			'is_published' => '1',
			'from' => null,
			'to' => null,
			'is_container_fluid' => '1',
		),
	);

}
