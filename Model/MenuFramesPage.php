<?php
/**
 * MenuFramesPage Model
 *
 * @property Page $Page
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenusAppModel', 'Menus.Model');

/**
 * Summary for MenuFramesPage Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Model
 */
class MenuFramesPage extends MenusAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'frame_key' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Page' => array(
			'className' => 'Pages.Page',
			'foreignKey' => 'page_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Get menu data
 *
 * @param int $roomId rooms.id
 * @param string $frameKey frames.key
 * @return array Menu data
 */
	public function getMenuData() {
		$this->LanguagesPage = ClassRegistry::init('Pages.LanguagesPage');

		//Menuデータ取得
		$menus = $this->Page->find('all', array(
			'recursive' => -1,
			'fields' => array(
				$this->Page->alias . '.*',
				$this->LanguagesPage->alias . '.*',
				$this->alias . '.*',
			),
			'conditions' => array(
				$this->Page->alias . '.room_id' => Current::read('Room.id'),
				//$this->LanguagesPage->alias . '.language_id' => Configure::read('Config.languageId'),
				//'OR' => array(
				//	$this->alias . '.is_hidden' => false,
				//	$this->alias . '.is_hidden IS NULL',
				//)
			),
			'joins' => array(
				array(
					'table' => $this->LanguagesPage->table,
					'alias' => $this->LanguagesPage->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Page->alias . '.id' . ' = ' . $this->LanguagesPage->alias . ' .page_id',
						$this->LanguagesPage->alias . '.language_id' => Current::read('Language.id'),
					),
				),
				array(
					'table' => $this->table,
					'alias' => $this->alias,
					'type' => 'LEFT',
					'conditions' => array(
						$this->Page->alias . '.id' . ' = ' . $this->alias . ' .page_id',
						$this->alias . '.frame_key' => Current::read('Frame.key')
					),
				),
			),
			'order' => array(
				$this->Page->alias . '.lft' => 'asc',
			)
		));

		if (! $menus) {
			return null;
		}
		return $menus;
	}

}
