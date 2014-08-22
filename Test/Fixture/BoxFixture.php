<?php
/**
 * BoxFixture
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.Menus.Test.Fixture
 */

/**
 * Summary for BoxFixture
 */
class BoxFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'container_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null),
		'space_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'page_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'container_id' => 1,
			'type' => 1,
			'space_id' => 1,
			'room_id' => 1,
			'page_id' => 1,
			'weight' => 1,
			'created_user_id' => 1,
			'created' => '2014-04-30 06:57:01',
			'modified_user_id' => 1,
			'modified' => '2014-04-30 06:57:01'
		),
		array(
			'id' => 2,
			'container_id' => 2,
			'type' => 1,
			'space_id' => 1,
			'room_id' => 1,
			'page_id' => 1,
			'weight' => 1,
			'created_user_id' => 1,
			'created' => '2014-04-30 06:57:01',
			'modified_user_id' => 1,
			'modified' => '2014-04-30 06:57:01'
		),
		array(
			'id' => 3,
			'container_id' => 3,
			'type' => 4,
			'space_id' => 1,
			'room_id' => 1,
			'page_id' => 1,
			'weight' => 1,
			'created_user_id' => 1,
			'created' => '2014-04-30 06:57:01',
			'modified_user_id' => 1,
			'modified' => '2014-04-30 06:57:01'
		),
		array(
			'id' => 4,
			'container_id' => 4,
			'type' => 1,
			'space_id' => 1,
			'room_id' => 1,
			'page_id' => 1,
			'weight' => 1,
			'created_user_id' => 1,
			'created' => '2014-04-30 06:57:01',
			'modified_user_id' => 1,
			'modified' => '2014-04-30 06:57:01'
		),
		array(
			'id' => 5,
			'container_id' => 5,
			'type' => 1,
			'space_id' => 1,
			'room_id' => 1,
			'page_id' => 1,
			'weight' => 1,
			'created_user_id' => 1,
			'created' => '2014-04-30 06:57:01',
			'modified_user_id' => 1,
			'modified' => '2014-04-30 06:57:01'
		),
		array(
			'id' => 6,
			'container_id' => 6,
			'type' => 1,
			'space_id' => 1,
			'room_id' => 1,
			'page_id' => 1,
			'weight' => 1,
			'created_user_id' => 1,
			'created' => '2014-04-30 06:57:01',
			'modified_user_id' => 1,
			'modified' => '2014-04-30 06:57:01'
		),
	);

}
