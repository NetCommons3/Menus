<?php
/**
 * Menus Controller
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.Menus.Controller
 */

App::uses('MenusAppController', 'Menus.Controller');

/**
 * Menus Controller
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.Menus.Controller
 * @since       NetCommons 3.0.0.0
 */
class MenusController extends MenusAppController {

/**
 * Language ID
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       int
 */
	public $langId = 2;

/**
 * Room Id
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	public $roomId = 1;

/**
 * Model name
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       array
 */
	public $uses = array(
		'Menus.MenuPage',
		'Frames.Frame',
		'Pages.Page'
	);

/**
 * beforeFilter
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   CakeResponse
 */
	public function index($frameId = 0) {
		//フレームIDからコンテナーIDを取得
		$frame = $this->Frame->findById($frameId);
		if (! $frame) {
			return;
		}
		//コンテナータイプを取得(Configure)
		$containerId = $frame['Box']['container_id'];
		$conainerTypes = array_flip(Configure::read('Containers.type'));

		if (! isset($conainerTypes[$containerId])) {
			return $this->render('Menus/index');
		}

		//リンクの設定
		$requestUri = env('REQUEST_URI');
		if (Configure::read('Pages.isSetting')) {
			$requestUri = mb_substr($requestUri, mb_strlen(Configure::read('Pages.settingModeWord')) + 1);
		}
		if (mb_substr($requestUri, 0, 1) == '/') {
			$requestUri = mb_substr($requestUri, 1);
		}
		if (mb_substr($requestUri, -1, 1) == '/') {
			$requestUri = mb_substr($requestUri, 0, -1);
		}
		$this->set('curSlug', $requestUri);

		//メニューデータ取得
		$menus = $this->MenuPage->getMenuData($this->roomId, $this->langId);
		$this->set('menus', $menus);

		//Viewの指定
		return $this->render('Menus/' . $conainerTypes[$containerId] . '/index');
	}
}
