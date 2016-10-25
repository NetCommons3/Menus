<?php
/**
 * MenuHelper::showRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * MenuHelper::showRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuHelper
 */
class MenuHelperShowRoomTest extends NetCommonsHelperTestCase {

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

		$roomIds = array('2', '5', '6');
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
 * showRoom()のテスト(グループルーム)
 *
 * @return void
 */
	public function testOnGroupRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['5'], '5');

		//テスト実施
		$result = $this->Menu->showRoom($menu);

		//チェック
		$this->assertTrue($result);
	}

/**
 * showRoom()のテスト(プライベートルーム)
 *
 * @return void
 */
	public function testOnPvivateRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.5.Room.parent_id', Room::PRIVATE_PARENT_ID);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['5'], '5');

		//テスト実施
		$result = $this->Menu->showRoom($menu);

		//チェック
		$this->assertFalse($result);
	}

/**
 * showRoom()のテスト(グループルーム、is_hidden=true)
 *
 * @return void
 */
	public function testIsHiddenOnGroupRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.5.MenuFramesRoom.is_hidden', true);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['5'], '5');

		//テスト実施
		$result = $this->Menu->showRoom($menu);

		//チェック
		$this->assertFalse($result);
	}

/**
 * showRoom()のテスト(グループルーム、defaultHidden=true、MenuFramesRoom.idなし)
 *
 * @return void
 */
	public function testDefaultHiddenWOMenuFramesRoomIdOnGroupRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'defaultHidden', true);
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.5.MenuFramesRoom.id', null);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['5'], '5');

		//テスト実施
		$result = $this->Menu->showRoom($menu);

		//チェック
		$this->assertFalse($result);
	}

/**
 * showRoom()のテスト(グループルーム、defaultHidden=true、MenuFramesRoom.idなし)
 *
 * @return void
 */
	public function testDefaultHiddenWOMenuFramesPageIdOnGroupRoom() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$viewVars = Hash::insert($viewVars, 'defaultHidden', true);
		$viewVars = Hash::insert($viewVars, 'menuFrameRooms.5.MenuFramesRoom.id', '9');
		$viewVars = Hash::insert($viewVars, 'menus.5.5.MenuFramesPage.id', null);

		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['5'], '5');

		//テスト実施
		$result = $this->Menu->showRoom($menu);

		//チェック
		$this->assertFalse($result);
	}

}
