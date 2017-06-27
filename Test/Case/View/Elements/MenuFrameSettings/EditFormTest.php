<?php
/**
 * View/Elements/MenuFrameSettings/edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/MenuFrameSettings/edit_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Elements\MenuFrameSettings\EditForm
 */
class MenusViewElementsMenuFrameSettingsEditFormTest extends NetCommonsControllerTestCase {

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
		//テストコントローラ生成
		$this->generateNc('TestMenus.TestViewElementsMenuFrameSettingsEditForm');

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
 * View/Elements/MenuFrameSettings/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_menus/test_view_elements_menu_frame_settings_edit_form/edit_form?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/MenuFrameSettings/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[Frame][id]', '6', $this->view);
		$this->assertInput('input', 'data[MenuFrameSetting][id]', '3', $this->view);
		$this->assertInput('input', 'data[MenuFrameSetting][frame_key]', 'frame_3', $this->view);
		$this->assertInput('selecte', 'data[MenuFrameSetting][display_type]', null, $this->view);
		$this->assertInput('option', 'footer', null, $this->view);
		$this->assertInput('option', 'footer', null, $this->view);
		$this->assertInput('option', 'major', 'selected', $this->view);
		$this->assertInput('option', 'minor', null, $this->view);

		//$this->Menu->checkboxMenuFramesRoom()が通っているかチェック
		$this->assertInput('input', 'data[Menus][2][1][MenuFramesPage][id]', '1', $this->view);

		//$this->Menu->checkboxMenuFramesPage()が通っているかチェック
		$this->assertInput('input', 'data[Menus][2][4][MenuFramesPage][id]', '1', $this->view);
	}

}
