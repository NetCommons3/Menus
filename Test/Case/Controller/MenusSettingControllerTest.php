<?php
/**
 * MenusController Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

App::uses('MenusController', 'Menus.Controller');

/**
 * MenusController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Menus\Test\Case\Controller
 */
class MenusSettingControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.boxes.box',
		'plugin.boxes.boxes_page',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.net_commons.site_setting',
		'plugin.pages.languages_page',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.plugin_manager.plugin',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.room',
		'plugin.rooms.room_role_permission',
		'plugin.users.user',
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
		$frameId = 99999;
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
			'/' . Page::SETTING_MODE_WORD,
			'/' . Page::SETTING_MODE_WORD . '/',
			'/' . Page::SETTING_MODE_WORD . '/test',
			'/' . Page::SETTING_MODE_WORD . '/test/',
		);

		$frameId = 1;
		foreach ($slugs as $slug) {
			$_SERVER['REQUEST_URI'] = $slug;
			$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

			$this->assertTextNotContains('ERROR', $this->view, $slug);
		}
	}
}
