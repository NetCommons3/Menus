<?php
/**
 * FrameFixture
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

/**
 * FrameFixture
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Menus\Test\Fixture
 */
class FrameFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var      array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'box_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'block_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the frame.', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Name of the frame.', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
		'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => '一般以下のパートが閲覧可能かどうか。

ルーム配下ならルーム管理者、またはそれに準ずるユーザ(room_parts.edit_page, room_parts.create_page 双方が true のユーザ)はこの値に関わらず閲覧できる。
e.g.) ルーム管理者、またはそれに準ずるユーザ: ルーム管理者、編集長'),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame from.'),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame to.'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var      array
 */
	public $records = array(
		array(
			'id' => 1,
			'language_id' => 2,
			'room_id' => 1,
			'box_id' => 1, //Header box
			'plugin_key' => 'menus',
			'block_id' => 1,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 2,
			'language_id' => 2,
			'room_id' => 1,
			'box_id' => 2, //Left box
			'plugin_key' => 'menus',
			'block_id' => 2,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 3,
			'language_id' => 2,
			'room_id' => 1,
			'box_id' => 3, //Main box
			'plugin_key' => 'menus',
			'block_id' => 3,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 4,
			'language_id' => 2,
			'room_id' => 1,
			'box_id' => 4, //Right box
			'plugin_key' => 'menus',
			'block_id' => 4,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 5,
			'language_id' => 2,
			'room_id' => 1,
			'box_id' => 5, //Footer box
			'plugin_key' => 'menus',
			'block_id' => 5,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 6,
			'language_id' => 2,
			'room_id' => 1,
			'box_id' => 6, //Error
			'plugin_key' => 'menus',
			'block_id' => 6,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
	);

}
