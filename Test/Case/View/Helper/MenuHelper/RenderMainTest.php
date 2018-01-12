<?php
/**
 * MenuHelper::renderMain()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('MenuFrameSettingFixture', 'Menus.Test/Fixture');

/**
 * MenuHelper::renderMain()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuHelper
 */
class MenuHelperRenderMainTest extends NetCommonsHelperTestCase {

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
		Current::$current = Hash::insert(Current::$current, 'Page.id', $pageId);

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
		$viewVars['treeList4Disp'] = $viewVars['pageTreeList'];
		$viewVars['pages'] = $Page->getPages($roomIds);
		$viewVars['parentPages'] = $Page->getPath(Current::read('Page.id'));

		return $viewVars;
	}

/**
 * renderMain()のテスト
 *
 * @return void
 */
	public function testRenderMainWithActive() {
		//Helperロード
		$viewVars = $this->__getViewVars('2');
		$viewVars['parentPages'] = array();
		$requestData = array();
		$params = array(
			'plugin' => $this->plugin,
			'controller' => 'menus',
			'action' => 'index'
		);
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->renderMain();

		//チェック
		$this->assertEquals(array('1', Current::read('Page.id')), $this->Menu->parentPageIds);
	}

/**
 * renderMain()のテスト
 *
 * @return void
 */
	public function testRenderMainWithoutActive() {
		//Helperロード
		$viewVars = $this->__getViewVars('1');
		$requestData = array();
		$params = array(
			'plugin' => $this->plugin,
			'controller' => 'menus',
			'action' => 'index'
		);
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->renderMain();

		//チェック
		$this->assertEquals(array(Current::read('Page.id')), $this->Menu->parentPageIds);
	}

/**
 * renderMain()のテスト
 *
 * @return void
 */
	public function testRenderMainWithCssAndJs() {
		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Menus', 'TestMenus');

		//Helperロード
		$viewVars = $this->__getViewVars('2');
		$requestData = array();
		$params = array(
			'plugin' => 'test_menus',
			'controller' => 'menus',
			'action' => 'index'
		);
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->renderMain();

		//cssのURLチェック
		$pattern = '/<link.*?' . preg_quote('/test_menus/css/major/style.css', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->Menu->_View->fetch('css'));

		//scriptのURLチェック
		$pattern = '/<script.*?' . preg_quote('/test_menus/js/major/test_menus.js', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->Menu->_View->fetch('script'));
	}

}
