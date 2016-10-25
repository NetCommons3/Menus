<?php
/**
 * MenuFramesPage::getMenuData()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * MenuFramesPage::getMenuData()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Model\MenuFramesPage
 */
class MenuFramesPageGetMenuDataTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.menus.menu_frame_setting',
		'plugin.menus.menu_frames_page',
		'plugin.menus.menu_frames_room',
		'plugin.menus.page4menu',
		'plugin.menus.pages_language4menu',
		'plugin.rooms.room4test',
		'plugin.rooms.rooms_language4test',
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
	protected $_modelName = 'MenuFramesPage';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getMenuData';

/**
 * getMenuData()のテスト(MenuFramesPageデータあり)
 *
 * @return void
 */
	public function testGetMenuDataWithMenuFramesPage() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current = Hash::insert(Current::$current, 'Room.id', '2');
		Current::$current = Hash::insert(Current::$current, 'Frame.key', 'frame_3');
		$pageId = '4';
		$roomId = '2';
		$options = array(
			'conditions' => array('Page.id' => $pageId)
		);

		//テスト実施
		$result = $this->$model->$methodName($options);

		//チェック
		$this->__assertGetMenuData($result, $roomId, $pageId, 'home', 'Home ja');
		$this->assertEquals('8', $result[$roomId][$pageId]['PagesLanguage']['id']);
		$this->assertEquals('1', $result[$roomId][$pageId]['MenuFramesPage']['id']);
	}

/**
 * getMenuData()のテスト(MenuFramesPageデータなし)
 *
 * @return void
 */
	public function testGetMenuDataWOMenuFramesPage() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$pageId = '5';
		$roomId = '5';
		$options = array(
			'conditions' => array('Page.room_id' => $roomId)
		);

		//テスト実施
		$result = $this->$model->$methodName($options);

		//チェック
		$this->__assertGetMenuData($result, $roomId, $pageId, 'test2', 'Test page 2');
		$this->assertEquals('14', $result[$roomId][$pageId]['PagesLanguage']['id']);
		$this->assertEquals(null, $result[$roomId][$pageId]['MenuFramesPage']['id']);
	}

/**
 * getMenuData()の評価
 *
 * @param string $result 結果
 * @param int $roomId ルームID
 * @param int $pageId ページID
 * @param string $permalink パーマリンク
 * @param string $name ページ名
 * @return void
 */
	private function __assertGetMenuData($result, $roomId, $pageId, $permalink, $name) {
		//チェック
		$this->assertEquals(
			array('Page', 'PagesLanguage', 'MenuFramesPage'), array_keys($result[$roomId][$pageId])
		);
		$this->assertEquals($pageId, $result[$roomId][$pageId]['Page']['id']);
		$this->assertEquals($roomId, $result[$roomId][$pageId]['Page']['room_id']);
		$this->assertEquals($permalink, $result[$roomId][$pageId]['Page']['permalink']);

		$this->assertEquals($pageId, $result[$roomId][$pageId]['PagesLanguage']['page_id']);
		$this->assertEquals($name, $result[$roomId][$pageId]['PagesLanguage']['name']);
	}

}
