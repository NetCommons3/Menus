<?php
/**
 * MenuHelper::renderChild()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * MenuHelper::renderChild()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuHelper
 */
class MenuHelperRenderChildTest extends NetCommonsHelperTestCase {

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
		'plugin.rooms.room4test',
		'plugin.rooms.rooms_language4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'menus';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストデータ生成
		$viewVars = $this->__getViewVars();
		$requestData = array();
		$params = array();

		//Helperロード
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);
	}

/**
 * viewVarsのデータ取得
 *
 * @return array
 */
	private function __getViewVars() {
		$MenuFrameSetting = ClassRegistry::init('Menus.MenuFrameSetting');
		$MenuFramesRoom = ClassRegistry::init('Menus.MenuFramesRoom');
		$MenuFramesPage = ClassRegistry::init('Menus.MenuFramesPage');
		$Page = ClassRegistry::init('Pages.Page');

		$roomIds = array('1', '4', '5');
		Current::$current = Hash::insert(Current::$current, 'Page.id', '2');

		$viewVars = array();
		$viewVars['menus'] = $MenuFramesPage->getMenuData(array(
			'conditions' => array('Page.room_id' => $roomIds)
		));
		$viewVars['menus'] = Hash::insert($viewVars['menus'], '1.4.MenuFramesPage.folder_type', true);

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
 * renderChild()のテスト
 *
 * @return void
 */
	public function testRenderChild() {
		//データ生成
		$roomId = '1';
		$pageId = '2';
		$listTag = false;

		//テスト実施
		$this->Menu->parentPageIds = array('2');
		$result = $this->Menu->renderChild($roomId, $pageId, $listTag);

		//チェック
		$this->assertTextContains('<a href="#" class="list-group-item menu-tree-1" id="MenuFramesPage4"', $result);
		$this->assertTextContains('<a href="/page_6" class="list-group-item menu-tree-2" id="MenuFramesPage7', $result);
	}

}
