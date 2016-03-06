<?php
/**
 * MenuFramesRoom::getMenuFrameRooms()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * MenuFramesRoom::getMenuFrameRooms()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Model\MenuFramesRoom
 */
class MenuFramesRoomGetMenuFrameRoomsTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.menus.menu_frame_setting',
		'plugin.menus.menu_frames_page',
		'plugin.menus.menu_frames_room',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'menus';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'MenuFramesRoom';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getMenuFrameRooms';

/**
 * getMenuFrameRooms()のテストのDataProvider
 *
 * ### 戻り値
 *  - frameKey フレームKey
 *  - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('frameKey' => 'frame_1', 'expected' => array(
				'MenuFramesRoom' => array(
					'id' => null, 'frame_key' => null, 'room_id' => null, 'is_hidden' => null
				),
			)),
			array('frameKey' => 'frame_3', 'expected' => array(
				'MenuFramesRoom' => array(
					'id' => '1', 'frame_key' => 'frame_3', 'room_id' => '1', 'is_hidden' => false
				),
			)),
		);
	}

/**
 * getMenuFrameRooms()のテスト
 *
 * @param string $frameKey フレームKey
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetMenuFrameRooms($frameKey, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$roomId = '1';
		Current::$current = Hash::insert(Current::$current, 'Frame.key', $frameKey);
		$options = array('conditions' => array(
			'Room.id' => $roomId
		));

		//テスト実施
		$result = $this->$model->$methodName($options);

		//チェック
		$expected = Hash::merge(array(
			'Room' => array('page_id_top' => '1'),
			'RoomsLanguage' => array('id' => '2', 'name' => 'Room name'),
		), $expected);

		$this->assertEquals(array('Room', 'RoomsLanguage', 'MenuFramesRoom'), array_keys($result[$roomId]));
		$this->assertEquals($roomId, Hash::get($result[$roomId], 'Room.id'));

		$keyPath = 'Room.page_id_top';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($result[$roomId], $keyPath));

		$keyPath = 'RoomsLanguage.id';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($result[$roomId], $keyPath));

		$keyPath = 'RoomsLanguage.room_id';
		$this->assertEquals($roomId, Hash::get($result[$roomId], $keyPath));

		$keyPath = 'RoomsLanguage.name';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($result[$roomId], $keyPath));

		$keyPath = 'MenuFramesRoom.id';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($result[$roomId], $keyPath));

		$keyPath = 'MenuFramesRoom.frame_key';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($result[$roomId], $keyPath));

		$keyPath = 'MenuFramesRoom.room_id';
		$this->assertEquals(Hash::get($expected, $keyPath), Hash::get($result[$roomId], $keyPath));
	}

}
