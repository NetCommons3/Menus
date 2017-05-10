<?php
/**
 * メインタイプを削除する Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');
App::uses('MenuFrameSetting', 'Menus.Model');

/**
 * メインタイプを削除する Migration
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\Menus\Config\Migration
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class DeleteMainType extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_main_type';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
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
		if ($direction === 'up') {
			$MenuFrameSetting = $this->generateModel('MenuFrameSetting');
			$update = array(
				'MenuFrameSetting.display_type' => "'major'"
			);
			$conditions = array(
				'MenuFrameSetting.display_type' => 'main'
			);
			if (! $MenuFrameSetting->updateAll($update, $conditions)) {
				return false;
			}
		}
		return true;
	}
}
