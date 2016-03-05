<?php
/**
 * MenuFrameSetting::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('MenuFrameSettingFixture', 'Menus.Test/Fixture');
App::uses('MenuFramesPageFixture', 'Menus.Test/Fixture');

/**
 * MenuFrameSetting::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Model\MenuFrameSetting
 */
class MenuFrameSettingValidateTest extends NetCommonsValidateTest {

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
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['MenuFrameSetting'] = (new MenuFrameSettingFixture())->records[0];
		$data['Menus'][0][0]['MenuFramesPage'] = (new MenuFramesPageFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'frame_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_type', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

/**
 * MenuFramesPageのValidationErrorのテスト
 *
 * @return void
 */
	public function testMenuFramesPageOnValidationError() {
		$model = $this->_modelName;

		$data = $this->dataProviderValidationError()[0]['data'];
		$data['Menus'][0][0]['MenuFramesPage']['frame_key'] = '';

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertFalse($result);

		$this->assertEquals(
			$this->$model->MenuFramesPage->validationErrors[1]['frame_key'][0],
			__d('net_commons', 'Invalid request.')
		);
	}

}
