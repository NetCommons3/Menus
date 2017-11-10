<?php
/**
 * MenuFormHelper::checkboxMenuFramesRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('MenuFramesPageFixture', 'Menus.Test/Fixture');
App::uses('MenuFrameSettingFixture', 'Menus.Test/Fixture');

/**
 * MenuFormHelper::checkboxMenuFramesRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuFormHelper
 */
class MenuFormHelperCheckboxMenuFramesRoomTest extends NetCommonsHelperTestCase {

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
 * checkboxMenuFramesPage()のテストのDataProvider
 *
 * ### 戻り値
 *  - room ルームデータ
 *  - menu メニューデータ
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * ネスト無し、MenuFramesPageデータあり
			array(
				'room' => array(
					'Room' => array('id' => '2', 'parent_id' => null, 'page_id_top' => '4'),
					'RoomsLanguage' => array(array('language_id' => '2', 'name' => 'Room name'))
				),
				'menu' => array(
					'MenuFramesPage' => (new MenuFramesPageFixture())->records[0],
				),
				'pageId' => '1'
			),
			// * ネストあり、MenuFramesPageデータなし
			array(
				'room' => array(
					'Room' => array('id' => '5', 'parent_id' => '1', 'page_id_top' => '5'),
					'RoomsLanguage' => array(array('language_id' => '2', 'name' => 'Room name'))
				),
				'menu' => array(
					'MenuFramesPage' => array(),
				),
				'pageId' => '5'
			),
			// * プライベートルーム
			array(
				'room' => array(
					'Room' => array('id' => '10', 'parent_id' => '2', 'page_id_top' => '9'),
					'RoomsLanguage' => array(array('language_id' => '2', 'name' => 'Room name'))
				),
				'menu' => array(
					'MenuFramesPage' => array(),
				),
				'pageId' => '9'
			),
		);
	}

/**
 * checkboxMenuFramesRoom()のテスト
 *
 * @param array $room ルームデータ
 * @param array $menu メニューデータ
 * @param int $pageId ページID
 * @dataProvider dataProvider
 * @return void
 */
	public function testCheckboxMenuFramesRoom($room, $menu, $pageId) {
		//データ生成
		$roomId = $room['Room']['id'];

		//Helperロード
		$viewVars = array(
			'pages' => array(
				$pageId => $menu
			)
		);
		$requestData = array(
			'Frame' => array('key' => 'frame_3'),
			'MenuFrameSetting' => (new MenuFrameSettingFixture())->records[0],
		);
		$params = array();
		$this->loadHelper('Menus.MenuForm', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->MenuForm->checkboxMenuFramesRoom($roomId, $room, $pageId);

		//チェック
		$this->assertTextContains('Room name', $result);

		if ($room['Room']['parent_id'] === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID)) {
			$this->assertInput('input',
					'data[MenuFrameSetting][is_private_room_hidden]', '0', $result);
			$this->assertInput('input',
					'data[MenuFrameSetting][is_private_room_hidden]', '1', $result);

			$this->assertTextNotContains('data[MenuFrameSetting][id]', $result);
			$this->assertTextNotContains('data[MenuFrameSetting][frame_key]', $result);
			$this->assertTextNotContains('data[MenuFrameSetting][room_id]', $result);
			$this->assertTextNotContains('data[MenuFrameSetting][is_hidden]', $result);

		} else {
			$this->assertTextNotContains('data[MenuFrameSetting][is_private_room_hidden]', $result);

			$field = 'id';
			$value = Hash::get($menu, 'MenuFramesPage.' . $field);
			$this->assertInput('input',
					'data[Menus][' . $roomId . '][' . $pageId . '][MenuFramesPage][' . $field . ']', $value, $result);

			$field = 'frame_key';
			$value = Hash::get($menu, 'MenuFramesPage.' . $field);
			$this->assertInput('input',
					'data[Menus][' . $roomId . '][' . $pageId . '][MenuFramesPage][' . $field . ']', $value, $result);

			$field = 'page_id';
			if ($room['Room']['id'] === Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID)) {
				// ページ一覧で、パブリックルームのルーム表示のみ、ページがないため、$room['Room']['page_id_top']から取れない。
				// そのため、Space::getPageIdSpace(Space::PUBLIC_SPACE_ID)で page_idをセット
				$value = Space::getPageIdSpace(Space::PUBLIC_SPACE_ID);
			} else {
				$value = Hash::get($menu, 'MenuFramesPage.' . $field);
			}
			$this->assertInput('input',
					'data[Menus][' . $roomId . '][' . $pageId . '][MenuFramesPage][' . $field . ']', $value, $result);

			$this->assertInput('input',
					'data[Menus][' . $roomId . '][' . $pageId . '][MenuFramesPage][is_hidden]', '0', $result);
			$this->assertInput('input',
					'data[Menus][' . $roomId . '][' . $pageId . '][MenuFramesPage][is_hidden]', '1', $result);
		}
	}

}
