<?php
/**
 * MenuFrameSetting Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenusAppModel', 'Menus.Model');

/**
 * MenuFrameSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Model
 */
class MenuFrameSetting extends MenusAppModel {

/**
 * Menu types
 *
 * @var array
 */
	static public $menuTypes = array(
		'header',
		'major',
		'main',
		'minor',
		'footer',
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

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
			'display_type' => array(
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

		if (! $this->MenuFramesPage->validateMany($this->data['Menus'])) {
			$this->validationErrors = Hash::merge(
				$this->validationErrors,
				$this->MenuFramesPage->validationErrors
			);
			return false;
		}

		return parent::beforeValidate($options);
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 * @throws InternalErrorException
 */
	public function afterSave($created, $options = array()) {
		//MenuFramesPage登録
		if (isset($this->data['Menus'])) {
			//MenuFramesPage登録処理
			foreach ($this->data['Menus'] as $menu) {
				if (! $this->MenuFramesPage->save($menu['MenuFramesPage'], false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}
		}

		parent::afterSave($created, $options);
	}

/**
 * メニュー設定データの取得処理
 *
 * @return array Menu data
 */
	public function getMenuFrameSetting() {
		$menuFrameSetting = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array('frame_key' => Current::read('Frame.key'))
		));
		if (! $menuFrameSetting) {
			$menuFrameSetting = $this->create(array(
				'display_type' => 'main'
			));
		}
		return $menuFrameSetting;
	}

/**
 * メニュー設定データの登録処理
 *
 * @param array $data received post data
 * @return bool True on success, false on failure
 * @throws InternalErrorException
 */
	public function saveMenuFrameSetting($data) {
		$this->loadModels([
			'MenuFrameSetting' => 'Menus.MenuFrameSetting',
			'MenuFramesPage' => 'Menus.MenuFramesPage',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//登録処理
			if (! $this->save($data, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
