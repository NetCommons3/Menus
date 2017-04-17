<?php
/**
 * Minorテンプレートの働きを「配下ページのみ表示」に変更することにより
 * これでにminorテンプレートを設定していたところをmajorにするように修正 Migration
 *
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');
App::uses('MenuFrameSetting', 'Menus.Model');

/**
 * MenuFrameSettingのminorを設定していたところはMajorにする修正 Migration
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\Menus\Config\Migration
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class MenuNewTemplateAdd extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'menu_new_template_add';

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
				'MenuFrameSetting.display_type' => 'minor'
			);
			if (! $MenuFrameSetting->updateAll($update, $conditions)) {
				return false;
			}
		}
		return true;
	}
}
