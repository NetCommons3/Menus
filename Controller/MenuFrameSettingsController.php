<?php
/**
 * MenuFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MenusAppController', 'Menus.Controller');

/**
 * MenuFrameSettings Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Controller
 */
class MenuFrameSettingsController extends MenusAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'edit' => 'page_editable',
			),
		),
	);

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesRoom',
		'Pages.Page',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Menus.Menu',
		'Menus.MenuForm'
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$page = $this->Page->getPageWithFrame('');
		$this->set('page', $page);
	}

/**
 * 前準備
 *
 * @return void
 */
	protected function _prepare() {
		//ルームデータ取得
		$conditions = $this->Room->getReadableRoomsConditions();
		//$conditions['recursive'] = 0;
		//$conditions['fields'] = ['Room.id', 'Room.page_id_top'];
		$rooms = $this->Room->find('all', $conditions);
		if (! $rooms) {
			return $this->setAction('throwBadRequest');
		}
		$setRoom = [];
		foreach ($rooms as $r) {
			$setRoom[$r['Room']['id']] = $r;
		}
		$this->set('rooms', $setRoom);
		//メニューデータ取得
		$menus = $this->MenuFramesPage->getMenuData(array(
			'conditions' => array(
					$this->Page->alias . '.room_id' => array_keys($this->viewVars['rooms'])
			)
		));
		$this->set('menus', $menus);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//フレームなしの場合、
		if (! Current::read('Frame.id')) {
			return $this->emptyRender();
		}

		$roomIds = array_keys($this->viewVars['rooms']);
		$pages = $this->Page->getPages($roomIds);
		$this->set('pages', $pages);

		if ($this->request->is(array('post', 'put'))) {
			//不要パラメータ除去
			unset($this->request->data['save']);
			//登録処理
			foreach ($this->request->data['MenuRooms'] as $i => $menuRoom) {
				$roomId = $menuRoom['MenuFramesRoom']['room_id'] ?? null;
				$pageId = $menuRoom['MenuFramesRoom']['page_id_top'] ?? null;
				$isHidden =
					$this->request->data['Menus'][$roomId][$pageId]['MenuFramesPage']['is_hidden'] ?? null;
				$this->request->data['MenuRooms'][$i]['MenuFramesRoom']['is_hidden'] = $isHidden;
			}

			if ($this->MenuFrameSetting->saveMenuFrameSetting($this->request->data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl());
			}
			$this->NetCommons->handleValidationError($this->MenuFrameSetting->validationErrors);
		}

		$this->request->data += $this->MenuFrameSetting->getMenuFrameSetting();
		$this->request->data['Frame'] = Current::read('Frame');
		$this->request->data['Menus'] = $this->viewVars['menus'];
		$this->request->data['MenuRooms'] = $this->MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array($this->Room->alias . '.id' => $roomIds)
		));

		//Treeリスト取得
		$pageTreeList = $this->Page->generateTreeList(
				array('Page.room_id' => $roomIds), null, null, Page::$treeParser);
		$this->set('pageTreeList', $pageTreeList);
	}

}
