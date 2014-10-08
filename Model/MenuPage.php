<?php
/**
 * MenuPage Model
 *
 * @property Page $Page
 * @property Language $Language
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * MenuPage Model
 *
 * @property Page $Page
 * @property Language $Language
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Menus\Model
 */
class MenuPage extends AppModel {

/**
 * table name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $useTable = 'languages_pages';

/**
 * model name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $name = "MenuPage";

/**
 * belongsTo associations
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $belongsTo = array(
		'Pages' => array(
			'className' => 'Pages',
			'foreignKey' => 'page_id',
			'conditions' => '',
			'type' => 'inner',
			'fields' => 'slug',
			'order' => ''
		),
	);

/**
 * get menu data
 *
 * @param int $roomId rooms.id
 * @param int $langId languages.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  int
 */
	public function getMenuData($roomId, $langId) {
		//メニューデータ取得
		$conditions = array(
			'Pages.room_id' => $roomId,
			$this->name . '.language_id' => $langId,
		);
		$order = array(
			$this->name . '.page_id' => 'ASC'
		);

		$menus = $this->find('all',
				array(
					'conditions' => $conditions,
					'order' => $order,
				)
			);

		if (! $menus) {
			return null;
		}
		return $menus;
	}

}
