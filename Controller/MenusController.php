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
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Menus.Menu'
	);

/**
 * indexアクション
 *
 * @return void
 */
	public function index() {
		//ルームデータ取得
		$rooms = $this->Room->find('all', $this->Room->getReadableRoomsConditions());
		$rooms = Hash::combine($rooms, '{n}.Room.id', '{n}');
		$this->set('rooms', $rooms);
		$roomsIds = Hash::extract($rooms, '{n}.Room.id');

		//メニュー設定データ取得
		$menuFrameSetting = $this->MenuFrameSetting->getMenuFrameSetting();
		$this->set('menuFrameSetting', $menuFrameSetting);

		//メニューデータ取得
		$menus = $this->MenuFramesPage->getMenuData(array(
			'conditions' => array(
				$this->Page->alias . '.room_id' => $roomsIds
			)
		));
		$this->set('menus', Hash::combine($menus, '{n}.Page.id', '{n}', '{n}.Page.room_id'));

		//ルームデータ取得処理
		$menuFrameRooms = $this->MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array(
				$this->Room->alias . '.id' => $roomsIds
			)
		));
		$this->set('menuFrameRooms', Hash::combine($menuFrameRooms, '{n}.Room.id', '{n}'));
	}

}
