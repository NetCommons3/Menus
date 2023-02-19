<?php
/**
 * MenuFramesPageFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for MenuFramesPageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Fixture
 */
class MenuFramesPageFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'frame_key' => 'frame_3',
			'page_id' => '4',
			'is_hidden' => false,
			'folder_type' => false,
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
