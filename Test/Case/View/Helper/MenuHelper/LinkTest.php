<?php
/**
 * MenuHelper::link()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * MenuHelper::link()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuHelper
 */
class MenuHelperLinkTest extends NetCommonsHelperTestCase {

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
 * link()のテスト(アクティブ、子ページあり)
 *
 * @return void
 */
	public function testLinkWithChildPageWithActive() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['1'], '9');
		$class = 'menu-tree-1 active';

		//テスト実施
		$this->Menu->parentPageIds = array('1', '9');
		$result = $this->Menu->link($menu, $class);

		//チェック
		$pattern = '<a href="/page_1" class="menu-tree-1 active" id="MenuFramesPage9">' .
						'<span class="glyphicon glyphicon-menu-down"> </span> Page 1' .
					'</a>';
		$this->assertEquals($pattern, $result);
	}

/**
 * link()のテスト(アクティブでない、子ページあり)
 *
 * @return void
 */
	public function testLinkWithChildPageWOActive() {
		//Helperロード
		$viewVars = $this->__getViewVars('10');
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['1'], '9');
		$class = 'menu-tree-1';

		//テスト実施
		$this->Menu->parentPageIds = array();
		$result = $this->Menu->link($menu, $class);

		//チェック
		$pattern = '<a href="/page_1" class="menu-tree-1" id="MenuFramesPage9">' .
						'<span class="glyphicon glyphicon-menu-right"> </span> Page 1' .
					'</a>';
		$this->assertEquals($pattern, $result);
	}

/**
 * link()のテスト(トップページ)
 *
 * @return void
 */
	public function testLinkTopPage() {
		//Helperロード
		$viewVars = $this->__getViewVars('4');
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['1'], '4');
		$class = 'menu-tree-1';

		//テスト実施
		$this->Menu->parentPageIds = array();
		$result = $this->Menu->link($menu, $class);

		//チェック
		$pattern = '<a href="/" class="menu-tree-1" id="MenuFramesPage4">' .
						'Home ja' .
					'</a>';
		$this->assertEquals($pattern, $result);
	}

/**
 * link()のテスト(ルームトップ)
 *
 * @return void
 */
	public function testLinkRoomTop() {
		//Helperロード
		$viewVars = $this->__getViewVars('5');
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['4'], '5');
		$class = 'menu-tree-1';

		//テスト実施
		$this->Menu->parentPageIds = array();
		$result = $this->Menu->link($menu, $class);

		//チェック
		$pattern = '<a href="/test2" class="menu-tree-1" id="MenuFramesPage5">' .
						'サブルーム１' .
					'</a>';
		$this->assertEquals($pattern, $result);
	}

/**
 * link()のテスト(トグル)
 *
 * @return void
 */
	public function testLinkToggle() {
		//Helperロード
		$viewVars = $this->__getViewVars('10');
		$viewVars['menus'] = Hash::insert($viewVars['menus'], '1.9.MenuFramesPage.folder_type', true);
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['1'], '9');
		$class = 'menu-tree-1';

		//テスト実施
		$this->Menu->parentPageIds = array();
		$result = $this->Menu->link($menu, $class);

		//チェック
		$pattern = '<a href="#" class="menu-tree-1" id="MenuFramesPage9".*?>' .
						'<span class="glyphicon glyphicon-menu-right".*?> <\/span> Page 1' .
					'<\/a>';
		$this->assertRegExp('/' . $pattern . '/', $result);
	}

/**
 * link()のテスト(セッティングモードON)
 *
 * @return void
 */
	public function testLinkWithSettingMode() {
		//Helperロード
		Current::isSettingMode(true);
		$viewVars = $this->__getViewVars('4');
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//データ生成
		$menu = Hash::get($viewVars['menus']['1'], '9');
		$class = 'menu-tree-1 active';

		//テスト実施
		$this->Menu->parentPageIds = array('1', '9');
		$result = $this->Menu->link($menu, $class);

		//チェック
		$pattern = '<a href="/setting/page_1" class="menu-tree-1 active" id="MenuFramesPage9">' .
						'<span class="glyphicon glyphicon-menu-down"> </span> Page 1' .
					'</a>';
		$this->assertEquals($pattern, $result);

		Current::isSettingMode(false);
	}

}
