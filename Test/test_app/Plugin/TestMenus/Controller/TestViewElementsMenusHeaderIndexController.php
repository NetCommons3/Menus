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
		$this->request->params['plugin'] = 'menus';
		$this->request->params['controller'] = 'menus';
		$this->autoRender = true;

		Current::write('Frame.id', $this->request->query['frame_id']);
		Current::write('Frame.header_type', 'default');
		Current::write('Frame.plugin_key', 'menus');
		Current::write('Page.id', '4');

		parent::index();
	}

}
