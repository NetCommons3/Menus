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
					'Room' => array('id' => '1', 'parent_id' => null, 'page_id_top' => '4')
				),
				'menu' => array(
					'Page' => Hash::extract((new Page4menuFixture())->records, '{n}[id=' . $pageId . ']')[0],
					'PagesLanguage' => Hash::extract((new PagesLanguage4menuFixture())->records, '{n}[page_id=' . $pageId . ']')[1],
					'MenuFramesPage' => (new MenuFramesPageFixture())->records[0],
				),
				'pageTreeList' => array($pageId => chr(9) . $pageId),
				'nest' => 1,
				'rootRoom' => array(
					'Room' => array('id' => '1', 'parent_id' => null, 'page_id_top' => '4')
				),
			),
			// * ネストあり、MenuFramesPageデータなし
			array(
				'room' => array(
					'Room' => array('id' => '1', 'parent_id' => null, 'page_id_top' => '4')
				),
				'menu' => array(
					'Page' => Hash::extract((new Page4menuFixture())->records, '{n}[id=' . $pageId . ']')[0],
					'PagesLanguage' => Hash::extract((new PagesLanguage4menuFixture())->records, '{n}[page_id=' . $pageId . ']')[1],
					'MenuFramesPage' => array(),
				),
				'pageTreeList' => array($pageId => chr(9) . chr(9) . $pageId),
				'nest' => 2,
				'rootRoom' => array(
					'Room' => array('id' => '1', 'parent_id' => null, 'page_id_top' => '4')
				),
			),
			// * プライベートルーム
			array(
				'room' => array(
					'Room' => array('id' => '9', 'parent_id' => '2', 'page_id_top' => '9')
				),
				'menu' => array(
					'Page' => array('id' => '9', 'room_id' => '10', 'parent_id' => null),
					'PagesLanguage' => array(),
					'MenuFramesPage' => array(),
				),
				'pageTreeList' => array(),
				'nest' => false,
				'rootRoom' => array(
					'Room' => array('id' => '9', 'parent_id' => '2', 'page_id_top' => '9')
				),
			),
			// * グループルーム
			array(
				'room' => array(
					'Room' => array('id' => '9', 'parent_id' => '3', 'page_id_top' => '9')
				),
				'menu' => array(
					'Page' => array('id' => '9', 'room_id' => '10', 'parent_id' => null),
					'PagesLanguage' => array(),
					'MenuFramesPage' => array(),
				),
				'pageTreeList' => array(),
				'nest' => false,
				'rootRoom' => array(
					'Room' => array('id' => '9', 'parent_id' => '3', 'page_id_top' => '9')
				),
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
 * @param array $rootRoom ルートのルームデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testCheckboxMenuFramesPage($room, $menu, $pageTreeList, $nest, $rootRoom) {
		//データ生成
		$roomId = $room['Room']['id'];
		$pageId = $menu['Page']['id'];
		$rootRoomId = $rootRoom['Room']['id'];

		//Helperロード
		$viewVars = array(
			'pageTreeList' => $pageTreeList,
			'pages' => array(
				$pageId => $menu
			)
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
		$result = $this->MenuForm->checkboxMenuFramesPage($roomId, $room, $pageId, $menu, $rootRoomId, $rootRoom);

		//チェック
		if ($nest === false) {
			$this->assertEmpty($result);

		} else {
			if ($nest <= 1) {
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
