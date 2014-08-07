<?php
/**
 * LanguageFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for LanguageFixture
 */
class LanguageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'code' => 'L',
			'weight' => 1,
			'is_active' => 1,
			'created_user_id' => 1,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 1,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 2,
			'code' => 'L',
			'weight' => 2,
			'is_active' => 1,
			'created_user_id' => 2,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 2,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 3,
			'code' => 'L',
			'weight' => 3,
			'is_active' => 1,
			'created_user_id' => 3,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 3,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 4,
			'code' => 'L',
			'weight' => 4,
			'is_active' => 1,
			'created_user_id' => 4,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 4,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 5,
			'code' => 'L',
			'weight' => 5,
			'is_active' => 1,
			'created_user_id' => 5,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 5,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 6,
			'code' => 'L',
			'weight' => 6,
			'is_active' => 1,
			'created_user_id' => 6,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 6,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 7,
			'code' => 'L',
			'weight' => 7,
			'is_active' => 1,
			'created_user_id' => 7,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 7,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 8,
			'code' => 'L',
			'weight' => 8,
			'is_active' => 1,
			'created_user_id' => 8,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 8,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 9,
			'code' => 'L',
			'weight' => 9,
			'is_active' => 1,
			'created_user_id' => 9,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 9,
			'modified' => '2014-06-18 05:05:04'
		),
		array(
			'id' => 10,
			'code' => 'L',
			'weight' => 10,
			'is_active' => 1,
			'created_user_id' => 10,
			'created' => '2014-06-18 05:05:04',
			'modified_user_id' => 10,
			'modified' => '2014-06-18 05:05:04'
		),
	);

}
