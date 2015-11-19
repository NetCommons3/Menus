<?php
/**
 * Migration file
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Migration file
 *
 * ルーム表示のための修正
 *
 * * menu_frames_rooms、menu_frames_pagesテーブルから表示順(weight)のフィールド削除
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Config\Migration
 */
class DeleteWeight extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_weight';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(),
			'drop_field' => array(
				'menu_frames_pages' => array('weight'),
				'menu_frames_rooms' => array('weight'),
			),
		),
		'down' => array(
			'drop_table' => array(),
			'create_field' => array(
				'menu_frames_pages' => array(
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
				),
				'menu_frames_rooms' => array(
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
