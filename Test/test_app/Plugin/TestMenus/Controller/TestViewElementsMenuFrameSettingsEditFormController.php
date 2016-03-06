<?php
/**
 * View/Elements/MenuFrameSettings/edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenuFrameSettingsController', 'Menus.Controller');

/**
 * View/Elements/MenuFrameSettings/edit_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\test_app\Plugin\TestMenus\Controller
 */
class TestViewElementsMenuFrameSettingsEditFormController extends MenuFrameSettingsController {

/**
 * layout
 *
 * @var array
 */
	public $layout = '';

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesPage',
		'Menus.MenuFramesRoom',
		'Pages.Page',
		'Rooms.Room',
	);

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form() {
		$this->autoRender = true;
		parent::edit();
	}

}
