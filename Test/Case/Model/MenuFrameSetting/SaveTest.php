<?php
/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('MenuFrameSettingFixture', 'Menus.Test/Fixture');

/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\Model\MenuFrameSetting
 */
class MenuFrameSettingSaveTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'save';

/**
 * POSTリクエストデータ生成
 *
 * @return array リクエストデータ
 */
	private function __data() {
		$data = array(
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
							'page_id' => '4',
							'is_hidden' => true,
						)
					),
					2 => array(
						'MenuFramesPage' => array(
							'id' => null,
							'frame_key' => 'frame_3',
							'page_id' => '2',
							'is_hidden' => false,
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
						'is_hidden' => true,
					)
				),
				4 => array(
					'MenuFramesRoom' => array(
						'id' => null,
						'frame_key' => 'frame_3',
						'room_id' => '5',
						'is_hidden' => false,
					)
				)
			)
		);

		return $data;
	}

/**
 * save()のテスト
 *
 * @return void
 */
	public function testSave() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$frameKey = 'frame_3';
		$data = $this->__data();

		//事前チェック
		$menuPageField = array_keys($data['Menus']['1']['1']['MenuFramesPage']);
		$menuPages = $this->$model->MenuFramesPage->find('all', array(
			'recursive' => -1,
			'fields' => $menuPageField,
			'conditions' => array(
				'frame_key' => $frameKey
			),
			'order' => array('id' => 'asc')
		));
		$menuRoomField = array_keys($data['MenuRooms']['1']['MenuFramesRoom']);
		$menuRooms = $this->$model->MenuFramesRoom->find('all', array(
			'recursive' => -1,
			'fields' => $menuRoomField,
			'conditions' => array(
				'frame_key' => $frameKey
			),
			'order' => array('id' => 'asc')
		));

		//テスト実施
		$result = $this->$model->$methodName($data);
		$this->assertNotEmpty($result);
		$this->assertInternalType('array', $result);

		//チェック
		$expected = array_merge($menuPages, array($data['Menus']['1']['2']));
		$expected[0]['MenuFramesPage']['is_hidden'] = true;
		$expected[1]['MenuFramesPage']['id'] = '2';
		$actual = $this->$model->MenuFramesPage->find('all', array(
			'recursive' => -1,
			'fields' => $menuPageField,
			'conditions' => array(
				'frame_key' => $frameKey
			),
			'order' => array('id' => 'asc')
		));
		$this->assertEquals($expected, $actual);

		$expected = array_merge($menuRooms, array($data['MenuRooms']['4']));
		$expected[0]['MenuFramesRoom']['is_hidden'] = true;
		$expected[1]['MenuFramesRoom']['id'] = '2';
		$actual = $this->$model->MenuFramesRoom->find('all', array(
			'recursive' => -1,
			'fields' => $menuRoomField,
			'conditions' => array(
				'frame_key' => $frameKey
			),
			'order' => array('id' => 'asc')
		));
		$this->assertEquals($expected, $actual);
	}

/**
 * save()のMenuFramesPageモデルのExceptionErrorテスト
 *
 * @return void
 */
	public function testMenuFramesPageOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$data = $this->__data();
		$this->_mockForReturnFalse($model, 'Menus.MenuFramesPage', 'saveMany');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->$model->$methodName($data);
	}

/**
 * save()のMenuFramesRoomモデルのExceptionErrorテスト
 *
 * @return void
 */
	public function testMenuFramesRoomOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$data = $this->__data();
		$this->_mockForReturnFalse($model, 'Menus.MenuFramesRoom', 'saveMany');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->$model->$methodName($data);
	}

}
