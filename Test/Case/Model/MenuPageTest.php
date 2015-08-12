<?php
/**
 * MenuPage Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

App::uses('MenuPage', 'Menus.Model');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');

/**
 * AccessCounter Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Menus\Test\Case\Model
 */
class MenuPageTest extends YACakeTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'plugin.pages.languages_page',
		//'plugin.pages.page',
		//'plugin.users.user',
	);

/**
 * setUp method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function setUp() {
		parent::setUp();
		$this->MenuPage = ClassRegistry::init('Menus.MenuPage');
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function tearDown() {
		unset($this->MenuPage);

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
 * testGetMenuData
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testGetMenuData() {
		$roomId = 1;
		$langId = 2;

		$mine = $this->MenuPage->getMenuData($roomId, $langId);

		$this->assertTrue(is_array($mine), print_r($mine, true));
	}

/**
 * testGetMenuData
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testGetMenuDataErr() {
		$roomId = 1;
		$langId = 999999999;

		$mine = $this->MenuPage->getMenuData($roomId, $langId);

		$this->assertNull($mine, print_r($mine, true));
	}

}
