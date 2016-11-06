<?php
/**
 * MenuFrameSettingsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * MenuFrameSettingsController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Controller\MenuFrameSettingsController
 */
class MenuFrameSettingsControllerEditTest extends NetCommonsControllerTestCase {

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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'menu_frame_settings';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * edit()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testEditGet() {
		//テストデータ
		$frameId = '6';

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'frame_id' => $frameId),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertEditGet($frameId);
	}

/**
 * edit()アクションのGetリクエストテスト(FrameIdが存在しない)
 *
 * @return void
 */
	public function testEditGetWOFrameId() {
		//テストデータ
		$blockId = '2';

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'block_id' => $blockId),
				array('method' => 'assertEmpty'), null, 'view');
	}

/**
 * edit()のチェック
 *
 * @param int $frameId フレームID
 * @return void
 */
	private function __assertEditGet($frameId) {
		$this->assertInput('form', null, 'menus/menu_frame_settings/edit', $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Frame][id]', $frameId, $this->view);

		$this->assertEquals($frameId, Hash::get($this->controller->request->data, 'Frame.id'));
	}

/**
 * POSTリクエストデータ生成
 *
 * @return array リクエストデータ
 */
	private function __data() {
		$data = array(
			'Frame' => array(
				'id' => '6',
				'key' => 'frame_3',
			),
			'MenuFrameSetting' => array(
				'id' => '3',
				'frame_key' => 'frame_3',
				'display_type' => 'main',
			),
			'Menus' => array(
				1 => array(
					1 => array(
						'MenuFramesPage' => array(
							'id' => '1',
							'frame_key' => 'frame_3',
							'page_id' => '1',
							'is_hidden' => false,
						)
					),
					2 => array(
						'MenuFramesPage' => array(
							'id' => null,
							'frame_key' => 'frame_3',
							'page_id' => null,
							'is_hidden' => null,
						)
					)
				),
			),
			'MenuRooms' => array(
				1 => array(
					'MenuFramesRoom' => array(
						'id' => '1',
						'frame_key' => 'frame_3',
						'room_id' => '2',
						'is_hidden' => false,
					)
				)
			)
		);

		return $data;
	}

/**
 * edit()アクションのPOSTリクエストテスト
 *
 * @return void
 */
	public function testEditPost() {
		//テストデータ
		$frameId = '6';

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'edit', 'frame_id' => $frameId), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$pattern = '/' . preg_quote('/', '/') . '/';
		$this->assertRegExp($pattern, $header['Location']);
	}

/**
 * ValidationErrorテスト
 *
 * @return void
 */
	public function testEditPostValidationError() {
		$this->_mockForReturnFalse('Menus.MenuFrameSetting', 'saveMenuFrameSetting');

		//テストデータ
		$frameId = '6';

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'edit', 'frame_id' => $frameId), null, 'view');

		$this->__assertEditGet('6');
	}

}
