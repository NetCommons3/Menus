<?php
/**
 * MenuHelper::showPrivateRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * MenuHelper::showPrivateRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuHelper
 */
class MenuHelperShowPrivateRoomTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.menus.menu_frame_setting',
		'plugin.menus.menu_frames_page',
		'plugin.menus.menu_frames_room',
		'plugin.menus.page4menu',
		'plugin.menus.pages_language4menu',
		'plugin.pages.room4pages',
		'plugin.rooms.rooms_language4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'menus';

/**
 * viewVarsのデータ取得
 *
 * @param int $pageId ページID
 * @return array
 */
	private function __getViewVars($pageId) {
		$MenuFrameSetting = ClassRegistry::init('Menus.MenuFrameSetting');
		$MenuFramesRoom = ClassRegistry::init('Menus.MenuFramesRoom');
		$MenuFramesPage = ClassRegistry::init('Menus.MenuFramesPage');
		$Page = ClassRegistry::init('Pages.Page');

		$roomIds = array('1', '4', '5');
		Current::write('Page.id', $pageId);

		$viewVars = array();
		$viewVars['menus'] = $MenuFramesPage->getMenuData(array(
			'conditions' => array('Page.room_id' => $roomIds)
		));
		$viewVars['menuFrameSetting'] = $MenuFrameSetting->getMenuFrameSetting();
		$menuFrameRooms = $MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array('Room.id' => $roomIds)
		));
		$viewVars['menuFrameRooms'] = Hash::combine($menuFrameRooms, '{n}.Room.id', '{n}');
		$viewVars['pageTreeList'] = $Page->generateTreeList(
				array('Page.room_id' => $roomIds), null, null, Page::$treeParser);
		$viewVars['pages'] = $Page->getPages($roomIds);
		$viewVars['parentPages'] = $Page->getPath(Current::read('Page.id'));

		return $viewVars;
	}

/**
 * showPrivateRoom()のテスト(プライベートルームでない)
 *
 * @return void
 */
	public function testNotPrivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['1'], '9');

		//テスト実施
		$result = $this->Menu->showPrivateRoom($menu);

		//チェック
		$this->assertFalse($result);
	}

/**
 * showPrivateRoom()のテスト(プライベートルーム)
 *
 * @return void
 */
	public function testOnPrivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.parent_id', Room::PRIVATE_PARENT_ID);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['4'], '5');

		//テスト実施
		$result = $this->Menu->showPrivateRoom($menu);

		//チェック
		$this->assertTrue($result);
	}

/**
 * showPrivateRoom()のテスト(プライベートルーム、プライベートルーム非表示)
 *
 * @return void
 */
	public function testHiddenPrivateRoomOnPrivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.parent_id', Room::PRIVATE_PARENT_ID);
		$viewVars = Hash::insert($viewVars, 'menuFrameSetting.MenuFrameSetting.is_private_room_hidden', true);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['4'], '5');

		//テスト実施
		$result = $this->Menu->showPrivateRoom($menu);

		//チェック
		$this->assertFalse($result);
	}

/**
 * showPrivateRoom()のテスト(プライベートルーム、プライベートのページ非表示)
 *
 * @return void
 */
	public function testHiddenPrivatePageOnPrivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.parent_id', Room::PRIVATE_PARENT_ID);
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.page_id_top', '99');
		$viewVars = Hash::insert($viewVars, 'defaultHidden', true);
		$viewVars = Hash::insert($viewVars, 'menus.4.5.MenuFramesPage.id', null);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['4'], '5');

		//テスト実施
		$result = $this->Menu->showPrivateRoom($menu);

		//チェック
		$this->assertFalse($result);
	}

/**
 * showPrivateRoom()のテスト(プライベートルーム、page_id_topが同じ)
 *
 * @return void
 */
	public function testSamePageIdTopOnPrivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.parent_id', Room::PRIVATE_PARENT_ID);
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.page_id_top', '5');
		$viewVars = Hash::insert($viewVars, 'defaultHidden', true);
		$viewVars = Hash::insert($viewVars, 'menus.4.5.MenuFramesPage.id', null);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['4'], '5');

		//テスト実施
		$result = $this->Menu->showPrivateRoom($menu);

		//チェック
		$this->assertTrue($result);
	}

/**
 * showPrivateRoom()のテスト(プライベートルーム、デフォルトでhiddenページでない)
 *
 * @return void
 */
	public function testWODefaultHiddenOnPrivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.parent_id', Room::PRIVATE_PARENT_ID);
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.page_id_top', '99');
		//$viewVars = Hash::insert($viewVars, 'defaultHidden', true);
		$viewVars = Hash::insert($viewVars, 'menus.4.5.MenuFramesPage.id', null);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['4'], '5');

		//テスト実施
		$result = $this->Menu->showPrivateRoom($menu);

		//チェック
		$this->assertTrue($result);
	}

/**
 * showPrivateRoom()のテスト(プライベートルーム、デフォルトでhiddenページの場合)
 *
 * @return void
 */
	public function testWMenuFramesPageIdOnPrivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.parent_id', Room::PRIVATE_PARENT_ID);
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.4.Room.page_id_top', '99');
		$viewVars = Hash::insert($viewVars, 'defaultHidden', true);
		$viewVars = Hash::insert($viewVars, 'menus.4.5.MenuFramesPage.id', '999');

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['4'], '5');

		//テスト実施
		$result = $this->Menu->showPrivateRoom($menu);

		//チェック
		$this->assertTrue($result);
	}

}
