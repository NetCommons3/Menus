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
		//パブリックスペースのページ（使われることはない）
		array(
			'id' => '1', 'room_id' => '2', 'root_id' => null, 'parent_id' => null, 'lft' => '1', 'rght' => '16',
			'permalink' => '', 'slug' => null,
		),
		//パブリックスペースのホーム
		array(
			'id' => '4', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '2', 'rght' => '5',
			'permalink' => 'home', 'slug' => 'home',
		),
		////ホーム/test4
		//array(
		//	'id' => '7', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '4', 'lft' => '3', 'rght' => '4',
		//	'permalink' => 'test4', 'slug' => 'test4',
		//),
		//パブリックスペースのtest5
		array(
			'id' => '8', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '6', 'rght' => '7',
			'permalink' => 'test5', 'slug' => 'test5',
		),
		//page.permalink=page_1
		array(
			'id' => '9', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '8', 'rght' => '13',
			'permalink' => 'page_1', 'slug' => 'page_1',
		),
		//page.permalink=page_1/page_3
		array(
			'id' => '11', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '9', 'lft' => '9', 'rght' => '12',
			'permalink' => 'page_3', 'slug' => 'page_3',
		),
		//page.permalink=page_1/page_3/page_6
		array(
			'id' => '12', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '11', 'lft' => '10', 'rght' => '11',
			'permalink' => 'page_6', 'slug' => 'page_6',
		),
		//page.permalink=page_2
		array(
			'id' => '10', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '14', 'rght' => '15',
			'permalink' => 'page_2', 'slug' => 'page_2',
		),

		//プライベートスペースのページ（使われることはない）
		array(
			'id' => '2', 'room_id' => '3', 'root_id' => null, 'parent_id' => null, 'lft' => '17', 'rght' => '18',
			'permalink' => '', 'slug' => null,
		),
		//グループスペースのページ（使われることはない）
		array(
			'id' => '3', 'room_id' => '4', 'root_id' => null, 'parent_id' => null, 'lft' => '19', 'rght' => '24',
			'permalink' => '', 'slug' => null,
		),
		//別ルーム(room_id=4)
		array(
			'id' => '5', 'room_id' => '5', 'root_id' => '3', 'parent_id' => '3', 'lft' => '20', 'rght' => '21',
			'permalink' => 'test2', 'slug' => 'test2',
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '6', 'room_id' => '6', 'root_id' => '3', 'parent_id' => '3', 'lft' => '22', 'rght' => '23',
			'permalink' => 'test3', 'slug' => 'test3',
		),
	);

}
