<?php
/**
 * FramesLanguageFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for FramesLanguageFixture
 */
class FramesLanguageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'frame_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'frame_id' => 1,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 1,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 1,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 2,
			'frame_id' => 2,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 2,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 2,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 3,
			'frame_id' => 3,
			'language_id' => 3,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 3,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 3,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 4,
			'frame_id' => 4,
			'language_id' => 4,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 4,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 4,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 5,
			'frame_id' => 5,
			'language_id' => 5,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 5,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 5,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 6,
			'frame_id' => 6,
			'language_id' => 6,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 6,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 6,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 7,
			'frame_id' => 7,
			'language_id' => 7,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 7,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 7,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 8,
			'frame_id' => 8,
			'language_id' => 8,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 8,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 8,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 9,
			'frame_id' => 9,
			'language_id' => 9,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 9,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 9,
			'modified' => '2014-06-18 05:49:20'
		),
		array(
			'id' => 10,
			'frame_id' => 10,
			'language_id' => 10,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user_id' => 10,
			'created' => '2014-06-18 05:49:20',
			'modified_user_id' => 10,
			'modified' => '2014-06-18 05:49:20'
		),
	);

}
