<?php
/**
 * PageFixture
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.Menus.Test.Fixture
 */

/**
 * PageFixture
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.Menus.Test.Case
 */
class PageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var      array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
		'permalink' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var      array
 */
	public $records = array(
		array(
			'id' => '1',
			'room_id' => '1',
			'parent_id' => null,
			'lft' => 1,
			'rght' => 2,
			'permalink' => '',
			'slug' => null,
			'is_published' => 1,
			'from' => null,
			'to' => null,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		array(
			'id' => '2',
			'room_id' => '1',
			'parent_id' => 1,
			'lft' => 3,
			'rght' => 4,
			'permalink' => 'test',
			'slug' => 'test',
			'is_published' => 1,
			'from' => null,
			'to' => null,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
	);

}
