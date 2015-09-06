<?php
/**
 * Menus Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenusAppController', 'Menus.Controller');
App::uses('PageLayoutHelper', 'Pages.View/Helper');

/**
 * Menus Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Controller
 */
class MenusController extends MenusAppController {

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsRoomRole' => array(),
	);

/**
 * Model name
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       array
 */
	public $uses = array(
		'Frames.Frame',
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesPage',
		'Pages.Page',
		'Containers.Container',
	);

/**
 * index
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function index($frameId = null) {
		//フレームデータ取得
		$frame = $this->Frame->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $frameId)
		));
		if (! $frame) {
			$this->autoRender = false;
			return;
		}

		if (Current::read('Page.room_id')) {
			$roomId = Current::read('Page.room_id');
		} else {
			$roomId = $frame['Frame']['room_id'];
		}

		//メニュー設定データ取得
		$menuFrameSetting = $this->MenuFrameSetting->find('first', array(
			'recursive' => -1,
			'conditions' => array('frame_key' => $frame['Frame']['key'])
		));
		if (! $menuFrameSetting) {
			$menuFrameSetting = $this->MenuFrameSetting->create(array(
				'display_type' => 'main'
			));
		}
		$this->set('menuFrameSetting', $menuFrameSetting);

		//メニューデータ取得
		$menus = $this->MenuFramesPage->getMenuData($roomId, $frame['Frame']['key']);

		$this->set('menus', $menus);
	}

}
