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
		'display_type' => array(
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

/**
 * Save menu frame setting
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
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		if (! $this->validateMenuFrameSetting($data['MenuFrameSetting'])) {
			return false;
		}
		if (! $this->MenuFramesPage->validateMany($data['Menus'])) {
			$this->validationErrors = Hash::merge($this->validationErrors, $this->MenuFramesPage->validationErrors);
			return false;
		}

		try {
			//MenuFrameSetting登録処理
			if (! $this->save($data['MenuFrameSetting'], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//MenuFramesPage登録処理
			foreach ($data['Menus'] as $menu) {
				if (! $this->MenuFramesPage->save($menu['MenuFramesPage'], false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Validate MenuFrameSetting
 *
 * @param array $data received post data
 * @return bool True on success, false on validation error
 */
	public function validateMenuFrameSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		return true;
	}

}
