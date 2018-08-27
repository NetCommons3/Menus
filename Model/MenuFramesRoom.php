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
		$this->validate = array_merge($this->validate, array(
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
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
			'Space' => 'Rooms.Space',
		]);

		$roomsLangConditions = array(
			$this->Room->alias . '.id' . ' = ' . $this->RoomsLanguage->alias . ' .room_id',
			'OR' => array(
				'RoomsLanguage.language_id' => Current::read('Language.id'),
				array(
					'Space.is_m17n' => false,
					'OR' => array(
						'RoomsLanguage.id = OriginRoomsLanguage.id',
						'OriginRoomsLanguage.id' => null,
					)
				)
			)
		);

		//Menuデータ取得
		$options = Hash::merge(
			$this->__getDefaultQueryOptions(),
			$options,
			['conditions' => $roomsLangConditions]
		);

		$menuFrameRooms = $this->Room->find('all', $options);
		$result = array();
		foreach ($menuFrameRooms as $room) {
			$roomId = $room['Room']['id'];
			if (! isset($result[$roomId])) {
				$result[$roomId] = $room;
			} elseif ($room['RoomsLanguage']['language_id'] === Current::read('Language.id')) {
				$result[$roomId] = $room;
			}
		}

		$ret = [];
		foreach ($menuFrameRooms as $mfr) {
			$ret[$mfr['Room']['id']] = $mfr;
		}
		return $ret;
	}

/**
 * デフォルトのクエリオプションを取得する
 *
 * @return array
 */
	private function __getDefaultQueryOptions() {
		return array(
			'recursive' => -1,
			'fields' => array(
				$this->Room->alias . '.id',
				$this->Room->alias . '.space_id',
				$this->Room->alias . '.page_id_top',
				$this->Room->alias . '.parent_id',
				$this->Room->alias . '.active',
				$this->Room->alias . '.in_draft',
				$this->Room->alias . '.default_role_key',
				$this->RoomsLanguage->alias . '.room_id',
				$this->RoomsLanguage->alias . '.name',
				$this->alias . '.id',
				$this->alias . '.room_id',
				$this->alias . '.is_hidden',
			),
			'conditions' => array(
				$this->Room->alias . '.id' => Current::read('Room.id'),
				$this->Room->alias . '.page_id_top NOT' => null,
			),
			'joins' => array(
				array(
					'table' => $this->Space->table,
					'alias' => $this->Space->alias,
					'type' => 'INNER',
					'conditions' => array(
						'Room.space_id = Space.id',
					),
				),
				array(
					'table' => $this->RoomsLanguage->table,
					'alias' => $this->RoomsLanguage->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Room->alias . '.id' . ' = ' . $this->RoomsLanguage->alias . ' .room_id',
						'OR' => array(
							$this->RoomsLanguage->alias . '.language_id' => Current::read('Language.id'),
							'Space.is_m17n' => false,
						)
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
				array(
					'table' => $this->RoomsLanguage->table,
					'alias' => 'OriginRoomsLanguage',
					'type' => 'LEFT',
					'conditions' => array(
						'RoomsLanguage.room_id = OriginRoomsLanguage.room_id',
						'OriginRoomsLanguage.language_id' => Current::read('Language.id'),
					),
				),
			),
			'order' => array(
				$this->Room->alias . '.lft' => 'asc',
			)
		);
	}

}
