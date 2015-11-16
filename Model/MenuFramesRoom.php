<?php
/**
 * MenuFramesRoom Model
 *
 * @property Room $Room
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenusAppModel', 'Menus.Model');

/**
 * Summary for MenuFramesRoom Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Model
 */
class MenuFramesRoom extends MenusAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * メニューのルームデータ取得処理
 *
 * @param array $options Findのオプション
 * @return array Menu data
 */
	public function getMenuFrameRooms($options = array()) {
		$this->loadModels([
			'Room' => 'Rooms.Room',
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
		]);

		//Menuデータ取得
		$options = Hash::merge(array(
			'recursive' => -1,
			'fields' => array(
				$this->Room->alias . '.*',
				$this->RoomsLanguage->alias . '.*',
				$this->alias . '.*',
			),
			'conditions' => array(
				$this->Room->alias . '.id' => Current::read('Room.id'),
				$this->Room->alias . '.page_id_top NOT' => null,
			),
			'joins' => array(
				array(
					'table' => $this->RoomsLanguage->table,
					'alias' => $this->RoomsLanguage->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Room->alias . '.id' . ' = ' . $this->RoomsLanguage->alias . ' .room_id',
						$this->RoomsLanguage->alias . '.language_id' => Current::read('Language.id'),
					),
				),
				array(
					'table' => $this->table,
					'alias' => $this->alias,
					'type' => 'LEFT',
					'conditions' => array(
						$this->Room->alias . '.id' . ' = ' . $this->alias . ' .room_id',
						$this->alias . '.frame_key' => Current::read('Frame.key')
					),
				),
			),
			'order' => array(
				$this->alias . '.weight' => 'asc',
				$this->Room->alias . '.lft' => 'asc',
			)
		), $options);

		$menuFrameRooms = $this->Room->find('all', $options);
		return $menuFrameRooms;
	}

}
