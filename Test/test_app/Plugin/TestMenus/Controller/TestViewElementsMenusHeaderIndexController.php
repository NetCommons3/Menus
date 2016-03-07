<?php
/**
 * View/Elements/Menus/header/indexテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenusController', 'Menus.Controller');

/**
 * View/Elements/Menus/header/indexテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\test_app\Plugin\TestMenus\Controller
 */
class TestViewElementsMenusHeaderIndexController extends MenusController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesRoom',
		'Menus.MenuFramesPage',
		'Pages.Page',
		'Rooms.Room',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;
		parent::index();
	}

}
