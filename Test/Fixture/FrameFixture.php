<?php
/**
 * FrameFixture
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.Menus.Test.Fixture
 */

/**
 * FrameFixture
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.Menus.Test.Case
 */
class FrameFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @var      array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'box_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'plugin_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'block_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
 * @since    NetCommons 3.0.0.0
 * @var      array
 */
	public $records = array(
		array(
			'id' => 1,
			'room_id' => 1,
			'box_id' => 1, //Header box
			'plugin_id' => 1,
			'block_id' => 1,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 2,
			'room_id' => 1,
			'box_id' => 2, //Left box
			'plugin_id' => 1,
			'block_id' => 2,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 3,
			'room_id' => 1,
			'box_id' => 3, //Main box
			'plugin_id' => 1,
			'block_id' => 3,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 4,
			'room_id' => 1,
			'box_id' => 4, //Right box
			'plugin_id' => 1,
			'block_id' => 4,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 5,
			'room_id' => 1,
			'box_id' => 5, //Footer box
			'plugin_id' => 1,
			'block_id' => 5,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
		array(
			'id' => 6,
			'room_id' => 1,
			'box_id' => 6, //Error
			'plugin_id' => 1,
			'block_id' => 6,
			'weight' => null,
			'is_published' => true,
			'from' => '2014-07-08 15:34:16',
			'to' => '2014-08-08 15:34:16',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:16',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:16',
		),
	);

}
