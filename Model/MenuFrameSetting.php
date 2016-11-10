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
App::uses('Container', 'Containers.Model');

/**
 * MenuFrameSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Model
 */
class MenuFrameSetting extends MenusAppModel {

/**
 * ヘッダータイプ定数
 *
 * @var string
 */
	const DISPLAY_TYPE_HEADER = 'header';

/**
 * レフトタイプ定数
 *
 * @var string
 */
	const DISPLAY_TYPE_LEFT = 'major';

/**
 * ライトタイプ定数
 *
 * @var string
 */
	const DISPLAY_TYPE_RIGHT = 'minor';

/**
 * フッタータイプ定数
 *
 * @var string
 */
	const DISPLAY_TYPE_FOOTER = 'footer';

/**
 * メインタイプ定数
 *
 * @var string
 */
	const DISPLAY_TYPE_MAIN = 'main';

/**
 * メニューのリスト
 *
 * View/Elements/Menusのディレクトリを__constructでセットする
 *
 * @var array
 */
	public $menuTypes = array();

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

		foreach ($dirs[0] as $dir) {
			switch ($dir) {
				case self::DISPLAY_TYPE_FOOTER:
					$label = __d('menus', 'Footer type');
					break;
				case self::DISPLAY_TYPE_HEADER:
					$label = __d('menus', 'Header type');
					break;
				case self::DISPLAY_TYPE_LEFT:
					$label = __d('menus', 'Left type');
					break;
				case self::DISPLAY_TYPE_RIGHT:
					$label = __d('menus', 'Right type');
					break;
				default:
					$label = __d('menus', 'Main type');
			}
			$this->menuTypes[$dir] = $label;
		}

		$this->loadModels([
			'MenuFrameSetting' => 'Menus.MenuFrameSetting',
			'MenuFramesPage' => 'Menus.MenuFramesPage',
			'MenuFramesRoom' => 'Menus.MenuFramesRoom',
		]);
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
				),
			),
			'display_type' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'inList' => array(
					'rule' => array('inList', array_keys($this->menuTypes)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
		));

		if (Hash::get($this->data, 'Menus')) {
			$data = Hash::combine($this->data['Menus'], '{n}.{n}.MenuFramesPage.page_id', '{n}.{n}');
			if (! $this->MenuFramesPage->validateMany($data)) {
				$this->validationErrors = Hash::merge(
					$this->validationErrors, $this->MenuFramesPage->validationErrors
				);
				return false;
			}
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
			$data = Hash::combine($this->data['Menus'], '{n}.{n}.MenuFramesPage.page_id', '{n}.{n}');
			if (! $this->MenuFramesPage->saveMany($data, ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}
		if (isset($this->data['MenuRooms'])) {
			//MenuFramesRoom登録処理
			if (! $this->MenuFramesRoom->saveMany($this->data['MenuRooms'], ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
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
			$containerType = Current::read('Box.container_type');
			if ($containerType === Container::TYPE_HEADER) {
				$displayType = self::DISPLAY_TYPE_HEADER;
			} elseif ($containerType === Container::TYPE_MAJOR) {
				$displayType = self::DISPLAY_TYPE_LEFT;
			} elseif ($containerType === Container::TYPE_MINOR) {
				$displayType = self::DISPLAY_TYPE_RIGHT;
			} elseif ($containerType === Container::TYPE_FOOTER) {
				$displayType = self::DISPLAY_TYPE_FOOTER;
			} else {
				$displayType = self::DISPLAY_TYPE_MAIN;
			}

			$menuFrameSetting = $this->create(array(
				'display_type' => $displayType
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
