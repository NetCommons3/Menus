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
		'Menus.MenuFramesPage',
		'Menus.MenuFramesRoom',
		'Pages.Page',
		'Rooms.Room',
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
		$conditions = array(
			'Page.room_id' => $roomIds,
		);
		$pageTreeList = $this->Page->generateTreeList($conditions, null, null, Page::$treeParser);
		$this->set('pageTreeList', $pageTreeList);

		$pages = $this->Page->getPages($roomIds);
		$this->set('pages', $pages);

		$parentPages = $this->Page->getPath(Current::read('Page.id'));
		$this->set('parentPages', $parentPages);

		//メニューデータの有無
		$count1 = $this->MenuFramesRoom->find('count', array('recursive' => -1,
			'conditions' => array(
				$this->MenuFramesRoom->alias . '.frame_key' => Current::read('Frame.key')
			)
		));
		$count2 = $this->MenuFramesPage->find('count', array('recursive' => -1,
			'conditions' => array(
				$this->MenuFramesPage->alias . '.frame_key' => Current::read('Frame.key')
			)
		));

		if ($count1 && $count2) {
			$options = array(
				MenuFrameSetting::DISPLAY_TYPE_HEADER,
				MenuFrameSetting::DISPLAY_TYPE_FOOTER,
			);
		} else {
			$options = array();
		}
		$defaultHidden = in_array($menuFrameSetting['MenuFrameSetting']['display_type'], $options, true);
		$this->set('defaultHidden', $defaultHidden);
	}

}
