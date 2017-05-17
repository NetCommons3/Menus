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

		$this->_prepare();
	}

/**
 * 前準備
 *
 * @return void
 */
	protected function _prepare() {
		//ルームデータ取得
		$rooms = $this->Room->find('all', $this->Room->getReadableRoomsConditions());
		if (! $rooms) {
			return $this->setAction('throwBadRequest');
		}
		$this->set('rooms', Hash::combine($rooms, '{n}.Room.id', '{n}'));

		//メニューデータ取得
		$menus = $this->MenuFramesPage->getMenuData(array(
			'conditions' => array(
				$this->Page->alias . '.room_id' => array_keys($this->viewVars['rooms'])
			)
		));
		$this->set('menus', $menus);
	}

}
