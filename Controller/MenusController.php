<?php
/**
 * Menus Controller
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

App::uses('MenusAppController', 'Menus.Controller');
App::uses('Container', 'Containers.Model');

/**
 * Menus Controller
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Menus\Controller
 */
class MenusController extends MenusAppController {

/**
 * Language ID
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       int
 */
	public $langId = 2;

/**
 * Room Id
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       bool
 */
	public $roomId = 1;

/**
 * Model name
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
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
 * @return   CakeResponse
 */
	public function index($frameId = 0) {
		//フレームIDからコンテナーIDを取得
		$frame = $this->Frame->findById($frameId);
		if (! $frame) {
			$this->autoRender = false;
			return '';
		}
		//コンテナータイプを取得(Configure)
		$containerId = $frame['Box']['container_id'];
		$conainerTypes = array(
			Container::TYPE_HEADER => 'header',
			Container::TYPE_MAJOR => 'major',
			Container::TYPE_MAIN => 'main',
			Container::TYPE_MINOR => 'minor',
			Container::TYPE_FOOTER => 'footer',
		);

		if (! isset($conainerTypes[$containerId])) {
			$this->autoRender = false;
			return '';
		}

		//リンクの設定
		$requestUri = env('REQUEST_URI');
		if (Page::isSetting()) {
			$requestUri = mb_substr($requestUri, mb_strlen(Page::SETTING_MODE_WORD) + 1);
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
