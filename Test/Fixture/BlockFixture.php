<?php
/**
 * BlockFixture
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
 * Summary for BlockFixture
 */
class BlockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'room_id' => 1,
			'created_user_id' => 1,
			'created' => '2014-06-18 02:06:22',
			'modified_user_id' => 1,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 2,
			'room_id' => 1,
			'created_user_id' => 2,
			'created' => '2014-06-18 02:06:22',
			'modified_user_id' => 2,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 3,
			'room_id' => 1,
			'created_user_id' => 3,
			'created' => '2014-06-18 02:06:22',
			'modified_user_id' => 3,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 4,
			'room_id' => 1,
			'created_user_id' => 4,
			'created' => '2014-06-18 02:06:22',
			'modified_user_id' => 4,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 5,
			'room_id' => 1,
			'created_user_id' => 5,
			'created' => '2014-06-18 02:06:22',
			'modified_user_id' => 5,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 6,
			'room_id' => 1,
			'created_user_id' => 5,
			'created' => '2014-06-18 02:06:22',
			'modified_user_id' => 5,
			'modified' => '2014-06-18 02:06:22'
		),
	);

}
