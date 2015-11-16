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
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       array
 */
	public $uses = array(
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesPage',
		'Menus.MenuFramesRoom',
		'Pages.Page',
		'Rooms.Room',
	);

/**
 * indexアクション
 *
 * @return void
 */
	public function index() {
		//ルームデータ取得
		$rooms = $this->Room->find('all', $this->Room->getReadableRoomsCondtions());
		$rooms = Hash::combine($rooms, '{n}.Room.id', '{n}');
		$this->set('rooms', $rooms);

		//メニュー設定データ取得
		$menuFrameSetting = $this->MenuFrameSetting->getMenuFrameSetting();
		$this->set('menuFrameSetting', $menuFrameSetting);

		$roomsIds = Hash::extract($rooms, '{n}.Room.id');
//var_dump($roomsIds);

		//メニューデータ取得
		$menus = $this->MenuFramesPage->getMenuData(array(
			'conditions' => array(
				$this->Page->alias . '.room_id' => $roomsIds
			)
		));
		$menus = Hash::combine($menus, '{n}.Page.id', '{n}', '{n}.Page.room_id');

		$this->set('menus', $menus);
//		var_dump($menus);

		//ルームデータ取得処理
		$menuFrameRooms = $this->MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array(
				$this->Room->alias . '.id' => $roomsIds
			)
		));
		$this->set('menuFrameRooms', $menuFrameRooms);

//		var_dump($menuFrameRooms);
	}

}
