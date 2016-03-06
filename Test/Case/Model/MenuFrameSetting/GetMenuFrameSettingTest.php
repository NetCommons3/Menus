<?php
/**
 * MenuFrameSetting::getMenuFrameSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * MenuFrameSetting::getMenuFrameSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Model\MenuFrameSetting
 */
class MenuFrameSettingGetMenuFrameSettingTest extends NetCommonsGetTest {

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
	protected $_modelName = 'MenuFrameSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getMenuFrameSetting';

/**
 * getMenuFrameSetting()テストのDataProvider
 *
 * ### 戻り値
 *  - frameKey フレームKey
 *  - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('frameKey' => 'frame_2', 'expected' => array(
				'id' => '2',
				'frame_key' => 'frame_2',
				'display_type' => 'major',
				'created_user' => null,
				'created' => null,
				'modified_user' => null,
				'modified' => null,
			)),
			array('frameKey' => 'frame_8', 'expected' => array(
				'frame_key' => 'frame_8',
				'display_type' => 'main',
				'created_user' => null,
				'created' => null,
				'modified_user' => null,
				'modified' => null,
			)),
		);
	}

/**
 * getMenuFrameSetting()のテスト
 *
 * @param string $frameKey フレームKey
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetMenuFrameSetting($frameKey, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current = Hash::insert(Current::$current, 'Frame.key', $frameKey);

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$this->assertEquals(array('MenuFrameSetting' => $expected), $result);
	}

}
