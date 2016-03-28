<?php
/**
 * MenuFormHelper::checkboxMenuFramesPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('MenuFramesPageFixture', 'Menus.Test/Fixture');
App::uses('Page4menuFixture', 'Menus.Test/Fixture');
App::uses('PagesLanguage4menuFixture', 'Menus.Test/Fixture');

/**
 * MenuFormHelper::checkboxMenuFramesPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuFormHelper
 */
class MenuFormHelperCheckboxMenuFramesPageTest extends NetCommonsHelperTestCase {

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
	}

/**
 * checkboxMenuFramesPage()のテストのDataProvider
 *
 * ### 戻り値
 *  - room ルームデータ
 *  - menu メニューデータ
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		$pageId = '4';

		return array(
			// * ネスト無し、MenuFramesPageデータあり
			array(
				'room' => array(
					'Room' => array('id' => '1', 'parent_id' => null)
				),
				'menu' => array(
					'Page' => Hash::extract((new Page4menuFixture())->records, '{n}[id=' . $pageId . ']')[0],
					'LanguagesPage' => Hash::extract((new PagesLanguage4menuFixture())->records, '{n}[page_id=' . $pageId . ']')[1],
					'MenuFramesPage' => (new MenuFramesPageFixture())->records[0],
				),
				'pageTreeList' => array($pageId => $pageId),
				'nest' => 0,
			),
			// * ネストあり、MenuFramesPageデータなし
			array(
				'room' => array(
					'Room' => array('id' => '1', 'parent_id' => null)
				),
				'menu' => array(
					'Page' => Hash::extract((new Page4menuFixture())->records, '{n}[id=' . $pageId . ']')[0],
					'LanguagesPage' => Hash::extract((new PagesLanguage4menuFixture())->records, '{n}[page_id=' . $pageId . ']')[1],
					'MenuFramesPage' => array(),
				),
				'pageTreeList' => array($pageId => chr(9) . $pageId),
				'nest' => 1,
			),
			// * プライベートルーム
			array(
				'room' => array(
					'Room' => array('id' => '9', 'parent_id' => '2')
				),
				'menu' => array(
					'Page' => array('id' => '9', 'room_id' => '9', 'parent_id' => null),
					'LanguagesPage' => array(),
					'MenuFramesPage' => array(),
				),
				'pageTreeList' => array(),
				'nest' => false,
			),
			// * グループルーム
			array(
				'room' => array(
					'Room' => array('id' => '9', 'parent_id' => '3')
				),
				'menu' => array(
					'Page' => array('id' => '9', 'room_id' => '9', 'parent_id' => null),
					'LanguagesPage' => array(),
					'MenuFramesPage' => array(),
				),
				'pageTreeList' => array(),
				'nest' => false,
			),
		);
	}

/**
 * checkboxMenuFramesPage()のテスト
 *
 * @param array $room ルームデータ
 * @param array $menu メニューデータ
 * @param array $pageTreeList viewVars['pageTreeList']のデータ
 * @param int|bool $nest ネスト
 * @dataProvider dataProvider
 * @return void
 */
	public function testCheckboxMenuFramesPage($room, $menu, $pageTreeList, $nest) {
		//データ生成
		$roomId = $room['Room']['id'];
		$pageId = $menu['Page']['id'];

		//Helperロード
		$viewVars = array(
			'pageTreeList' => $pageTreeList
		);
		$requestData = array(
			'Frame' => array('key' => 'frame_3'),
			'Menus' => array(
				'1' => array($pageId => array('MenuFramesPage' => $menu['MenuFramesPage']))
			)
		);
		$params = array();
		$this->loadHelper('Menus.MenuForm', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->MenuForm->checkboxMenuFramesPage($roomId, $room, $pageId, $menu);

		//チェック
		if ($nest === false) {
			$this->assertEmpty($result);

		} else {
			if ($nest === 0) {
				$this->assertTextNotContains('<span class="menu-edit-tree">', $result);
			} else {
				$this->assertTextContains('<span class="menu-edit-tree">', $result);
			}
			$menuFramesPageId = Hash::get($requestData['Menus']['1'][$pageId], 'MenuFramesPage.id');
			$this->assertInput('input',
					'data[Menus][1][' . $pageId . '][MenuFramesPage][id]', $menuFramesPageId, $result);

			$frameKey = $requestData['Frame']['key'];
			$this->assertInput('input',
					'data[Menus][1][' . $pageId . '][MenuFramesPage][frame_key]', $frameKey, $result);

			$this->assertInput('input',
					'data[Menus][1][' . $pageId . '][MenuFramesPage][page_id]', $pageId, $result);

			$this->assertInput('input',
					'data[Menus][1][' . $pageId . '][MenuFramesPage][is_hidden]', '0', $result);

			$this->assertInput('input',
					'data[Menus][1][' . $pageId . '][MenuFramesPage][is_hidden]', '1', $result);

			$this->assertInput('input',
					'data[Menus][1][' . $pageId . '][MenuFramesPage][folder_type]', '0', $result);
		}
	}

}
