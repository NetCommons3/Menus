<?php
/**
 * Menus Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenusAppController', 'Menus.Controller');
App::uses('PageLayoutHelper', 'Pages.View/Helper');

/**
 * Menus Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Controller
 */
class MenusController extends MenusAppController {

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(),
	);

/**
 * Model name
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       array
 */
	public $uses = array(
		'Menus.MenuPage',
		'Frames.Frame',
		'Pages.Page',
		'Containers.Container',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		//フレームIDからコンテナーIDを取得
		$frame = $this->Frame->findById($this->viewVars['frameId']);
		if (! $frame) {
			$this->autoRender = false;
			return '';
		}

		//コンテナータイプを取得(Configure)
		$containerId = $frame['Box']['container_id'];
		if (! $container = $this->Container->findById($containerId)) {
			$this->autoRender = false;
			return '';
		}

		$conainerTypes = array(
			Container::TYPE_HEADER => 'header',
			Container::TYPE_MAJOR => 'major',
			Container::TYPE_MAIN => 'main',
			Container::TYPE_MINOR => 'minor',
			Container::TYPE_FOOTER => 'footer',
		);
		$this->set('containerType', $conainerTypes[$container['Container']['type']]);

		if (isset(PageLayoutHelper::$page)) {
			$roomId = PageLayoutHelper::$page['roomId'];
		} else {
			$roomId = $this->viewVars['roomId'];
		}

		//メニューデータ取得
		$menus = $this->MenuPage->getMenuData($roomId, $this->viewVars['languageId']);
		$this->set('menus', $menus);
	}
}
