<?php
/**
 * MenuHelper::beforeRender()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * MenuHelper::beforeRender()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Controller\Component\MenuHelper
 */
class MenuHelperBeforeRenderTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
	}

/**
 * beforeRender()のテスト
 *
 * @return void
 */
	public function testBeforeRender() {
		//テストコントローラ生成
		$this->generateNc('TestMenus.TestMenuHelperBeforeRender');

		//テスト実行
		$this->_testGetAction('/test_menus/test_menu_helper_before_render/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Helper/TestMenuHelperBeforeRender', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//cssのURLチェック
		$pattern = '/<link.*?' . preg_quote('/menus/css/style.css', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->contents);

		//scriptのURLチェック
		$pattern = '/<script.*?' . preg_quote('/menus/js/menus.js', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->contents);

	}

}
