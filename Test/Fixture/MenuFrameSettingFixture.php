<?php
/**
 * MenuFrameSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for MenuFrameSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Fixture
 */
class MenuFrameSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'frame_key' => 'frame_1',
			'display_type' => 'header',
			'is_private_room_hidden' => null,
		),
		array(
			'id' => '2',
			'frame_key' => 'frame_2',
			'display_type' => 'major',
			'is_private_room_hidden' => null,
		),
		array(
			'id' => '3',
			'frame_key' => 'frame_3',
			'display_type' => 'major',
			'is_private_room_hidden' => null,
		),
		array(
			'id' => '4',
			'frame_key' => 'frame_4',
			'display_type' => 'minor',
			'is_private_room_hidden' => null,
		),
		array(
			'id' => '5',
			'frame_key' => 'frame_5',
			'display_type' => 'footer',
			'is_private_room_hidden' => null,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Menus') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new MenusSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}
}
