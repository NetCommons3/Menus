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

/**
 * Menus Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Controller
 */
class MenusController extends MenusAppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesRoom',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Menus.Menu'
	);

/**
 * indexアクション
 *
 * @return void
 */
	public function index() {
		//ルームデータ取得
		$roomIds = array_keys($this->viewVars['rooms']);

		//メニュー設定データ取得
		$menuFrameSetting = $this->MenuFrameSetting->getMenuFrameSetting();
		$this->set('menuFrameSetting', $menuFrameSetting);

		//ルームデータ取得処理
		$menuFrameRooms = $this->MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array(
				$this->Room->alias . '.id' => $roomIds
			)
		));
		$this->set('menuFrameRooms', Hash::combine($menuFrameRooms, '{n}.Room.id', '{n}'));

		//Treeリスト取得
		$pageTreeList = $this->Page->generateTreeList(
				array('Page.room_id' => $roomIds), null, null, Page::$treeParser);
		$this->set('pageTreeList', $pageTreeList);

		$pages = $this->Page->getPages($roomIds);
		$this->set('pages', $pages);

		$parentPages = $this->Page->getPath(Current::read('Page.id'));
		$this->set('parentPages', $parentPages);
	}

}
