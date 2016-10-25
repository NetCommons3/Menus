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
App::uses('MenuFramesRoomFixture', 'Menus.Test/Fixture');
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
					'Room' => array('id' => '2', 'parent_id' => null),
					'RoomsLanguage' => array(array('language_id' => '2', 'name' => 'Room name'))
				),
				'menu' => array(
					'MenuFramesRoom' => (new MenuFramesRoomFixture())->records[0],
				),
			),
			// * ネストあり、MenuFramesPageデータなし
			array(
				'room' => array(
					'Room' => array('id' => '5', 'parent_id' => '1'),
					'RoomsLanguage' => array(array('language_id' => '2', 'name' => 'Room name'))
				),
				'menu' => array(
					'MenuFramesRoom' => array(),
				),
			),
			// * プライベートルーム
			array(
				'room' => array(
					'Room' => array('id' => '10', 'parent_id' => '2'),
					'RoomsLanguage' => array(array('language_id' => '2', 'name' => 'Room name'))
				),
				'menu' => array(
					'MenuFramesRoom' => array(),
				),
			),
		);
	}

/**
 * checkboxMenuFramesRoom()のテスト
 *
 * @param array $room ルームデータ
 * @param array $menu メニューデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testCheckboxMenuFramesRoom($room, $menu) {
		//データ生成
		$roomId = $room['Room']['id'];

		//Helperロード
		$viewVars = array();
		$requestData = array(
			'Frame' => array('key' => 'frame_3'),
			'MenuFrameSetting' => (new MenuFrameSettingFixture())->records[0],
			'MenuRooms' => array(
				$roomId => array('MenuFramesRoom' => $menu['MenuFramesRoom'])
			)
		);
		$params = array();
		$this->loadHelper('Menus.MenuForm', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->MenuForm->checkboxMenuFramesRoom($roomId, $room);

		//チェック
		$this->assertTextContains('Room name', $result);

		if ($room['Room']['parent_id'] === Room::PRIVATE_PARENT_ID) {
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
			$value = Hash::get($menu, 'MenuFramesRoom.' . $field);
			$this->assertInput('input',
					'data[MenuRooms][' . $roomId . '][MenuFramesRoom][' . $field . ']', $value, $result);

			$field = 'frame_key';
			$value = Hash::get($menu, 'MenuFramesRoom.' . $field);
			$this->assertInput('input',
					'data[MenuRooms][' . $roomId . '][MenuFramesRoom][' . $field . ']', $value, $result);

			$field = 'room_id';
			$value = Hash::get($menu, 'MenuFramesRoom.' . $field);
			$this->assertInput('input',
					'data[MenuRooms][' . $roomId . '][MenuFramesRoom][' . $field . ']', $value, $result);

			$this->assertInput('input',
					'data[MenuRooms][' . $roomId . '][MenuFramesRoom][is_hidden]', '0', $result);
			$this->assertInput('input',
					'data[MenuRooms][' . $roomId . '][MenuFramesRoom][is_hidden]', '1', $result);
		}
	}

}
