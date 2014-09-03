<?php
/**
 * MenusController Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.Test.Controller.Case
 */

App::uses('MenusController', 'Menus.Controller');

/**
 * MenusController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.Menus.Test.Controller.Case
 */
class MenusSettingControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'app.Session',
		'app.SiteSetting',
		'app.SiteSettingValue',
		'plugin.menus.languages_page',
		'plugin.menus.page',
		'plugin.menus.frame',
		'plugin.menus.block',
		'plugin.menus.box',
		'plugin.menus.plugin',
		'plugin.menus.language',
		'plugin.menus.frames_language',
	);

/**
 * setUp
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function setUp() {
		parent::setUp();

		//セッティングモードON
		Configure::write('Pages.isSetting', true);
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function tearDown() {
		//セッティングモードOFF
		Configure::write('Pages.isSetting', false);

		parent::tearDown();
	}

/**
 * testIndex
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

/**
 * testHeaderMenu
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testHeaderMenu() {
		$frameId = 1;
		$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * testLeftMenu
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testLeftMenu() {
		$frameId = 2;
		$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * testMainMenu
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testMainMenu() {
		$frameId = 3;
		$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * testRightMenu
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testRightMenu() {
		$frameId = 4;
		$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * testFooterMenu
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testFooterMenu() {
		$frameId = 5;
		$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * testNoContainerMenu
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testNoContainer() {
		$frameId = 6;
		$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * testNoContainerMenu
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testNoFrameId() {
		$frameId = 7;
		$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * testSlugs
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testSlugs() {
		$slugs = array(
			'/' . Configure::read('Pages.settingModeWord'),
			'/' . Configure::read('Pages.settingModeWord') . '/',
			'/' . Configure::read('Pages.settingModeWord') . '/test',
			'/' . Configure::read('Pages.settingModeWord') . '/test/',
		);

		$frameId = 1;
		foreach ($slugs as $slug) {
			$_SERVER['REQUEST_URI'] = $slug;
			$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

			$this->assertTextNotContains('ERROR', $this->view, $slug);
		}
	}
}
