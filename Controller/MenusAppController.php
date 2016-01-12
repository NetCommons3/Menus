<?php
/**
 * MenusApp Controller
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * MenusApp Controller
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Menus\Controller
 */
class MenusAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Pages.PageLayout',
		'Security'
	);

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Menus.MenuFramesPage',
		'Pages.Page',
		'Rooms.Room',
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//ルームデータ取得
		$rooms = $this->Room->find('all', $this->Room->getReadableRoomsConditions());
		$rooms = Hash::combine($rooms, '{n}.Room.id', '{n}');
		if (! $rooms) {
			$this->setAction('throwBadRequest');
			return;
		}
		$this->set('rooms', $rooms);

		//メニューデータ取得
		$menus = $this->MenuFramesPage->getMenuData(array(
			'conditions' => array($this->Page->alias . '.room_id' => array_keys($rooms))
		));
		$this->set('menus', $menus);
	}

}
