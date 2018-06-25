<?php
/**
 * MenusAppController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * MenusAppController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Controller\MenusAppController
 */
class MenusAppControllerBeforeFilterTest extends NetCommonsControllerTestCase {

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

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Menus', 'TestMenus');
		$this->generateNc('TestMenus.TestMenusAppControllerIndex');

		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * beforeFilter()のテスト
 *
 * @return void
 */
	public function testBeforeFilter() {
		//テスト実行
		$this->_testGetAction('/test_menus/test_menus_app_controller_index/index?frame_id=6', null);

		//チェック
		$this->assertCount(3, $this->vars['rooms']);
		$this->assertEquals(array('2', '5', '6'), array_keys($this->vars['rooms']));

		$this->assertCount(3, $this->vars['menus']);
		$this->assertEquals(array('2', '5', '6'), array_keys($this->vars['menus']));
		$this->assertCount(7, $this->vars['menus']['2']);
		$this->assertEquals(array('1', '4', '8', '9', '11', '12', '10'), array_keys($this->vars['menus']['2']));

		$this->__assertMenus('2', '4', array(
			'Page' => array('parent_id' => '1', 'permalink' => 'home'),
			'PagesLanguage' => array('name' => 'Home ja'),
			'MenuFramesPage' => array('id' => '1', 'frame_key' => 'frame_3'),
		));

		$this->__assertMenus('2', '9', array(
			'Page' => array('parent_id' => '1', 'permalink' => 'page_1'),
			'PagesLanguage' => array('name' => 'Page 1'),
			'MenuFramesPage' => array('id' => null, 'frame_key' => null),
		));

		$this->__assertMenus('2', '11', array(
			'Page' => array('parent_id' => '9', 'permalink' => 'page_3'),
			'PagesLanguage' => array('name' => 'Page 3'),
			'MenuFramesPage' => array('id' => null, 'frame_key' => null),
		));

		$this->__assertMenus('2', '12', array(
			'Page' => array('parent_id' => '11', 'permalink' => 'page_6'),
			'PagesLanguage' => array('name' => 'Page 6'),
			'MenuFramesPage' => array('id' => null, 'frame_key' => null),
		));

		$this->__assertMenus('2', '10', array(
			'Page' => array('parent_id' => '1', 'permalink' => 'page_2'),
			'PagesLanguage' => array('name' => 'Page 2'),
			'MenuFramesPage' => array('id' => null, 'frame_key' => null),
		));
	}

/**
 * vars['menus']のチェック
 *
 * @param int $roomId ルームID
 * @param int $pageId ページID
 * @param array $expected 期待値
 * @return void
 */
	private function __assertMenus($roomId, $pageId, $expected) {
		$menu = $this->vars['menus'][$roomId][$pageId];

		$this->assertEquals(array('Page', 'PagesLanguage', 'MenuFramesPage'), array_keys($menu));

		$this->assertEquals($pageId, $menu['Page']['id']);
		$this->assertEquals($roomId, $menu['Page']['room_id']);

		$keyPath = 'Page.parent_id';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($menu, $keyPath));

		$keyPath = 'Page.permalink';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($menu, $keyPath));

		//$keyPath = 'Page.slug';
		//$this->assertEquals(Hash::get($expected, 'Page.permalink'), Hash::get($menu, $keyPath));

		$keyPath = 'PagesLanguage.page_id';
		$this->assertEquals($pageId, $menu['PagesLanguage']['page_id']);

		$keyPath = 'PagesLanguage.name';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($menu, $keyPath));

		$keyPath = 'MenuFramesPage.id';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($menu, $keyPath));

		//$keyPath = 'MenuFramesPage.frame_key';
		//$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($menu, $keyPath));

		$keyPath = 'MenuFramesPage.page_id';
		if (Hash::get($expected, 'MenuFramesPage.id')) {
			$this->assertEquals($pageId, Hash::get($menu, $keyPath));
		} else {
			$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($menu, $keyPath));
		}
	}

/**
 * beforeFilter()のExceptionErrorテスト
 *
 * @return void
 */
	public function testBeforeFilterOnExceptionError() {
		$this->_mockForReturn('Rooms.Room', 'getReadableRoomsConditions', array('conditions' => array('Room.id' => '9999')));

		//テスト実行
		$this->_testGetAction('/test_menus/test_menus_app_controller_index/index?frame_id=999', null, 'BadRequestException');
	}

}
