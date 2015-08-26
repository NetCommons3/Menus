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
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');

/**
 * MenusController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Menus\Test\Case\Controller
 */
class MenusControllerTest extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'plugin.menus.menu_frame_setting',
		'plugin.menus.menu_frames_page',
	);

/**
 * setUp
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function setUp() {
		parent::setUp();
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
 * testNoFrameIdMenu
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
			'/test',
			'/test/'
		);

		$frameId = 1;
		foreach ($slugs as $slug) {
			$_SERVER['REQUEST_URI'] = $slug;
			$this->testAction('/menus/menus/index/' . $frameId . '/', array('method' => 'get'));

			$this->assertTextNotContains('ERROR', $this->view, $slug);
		}
	}

}
