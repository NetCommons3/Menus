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
App::uses('Folder', 'Utility');

/**
 * MenuFrameSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Model
 */
class MenuFrameSetting extends MenusAppModel {

/**
 * メニューのリスト
 *
 * View/Elements/Menusのディレクトリを__constructでセットする
 *
 * @var array
 */
	static public $menuTypes = array();

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$pluginDir = APP . 'Plugin' . DS . $this->plugin . DS . 'View' . DS . 'Elements' . DS . 'Menus';

		//カテゴリ間の区切り線
		$dirs = (new Folder($pluginDir))->read();
		self::$menuTypes = $dirs[0];
	}

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
