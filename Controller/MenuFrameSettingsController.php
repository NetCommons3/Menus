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
	public $layout = 'Frames.setting';

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

		if ($this->request->is(array('post', 'put'))) {
			//不要パラメータ除去
			unset($this->request->data['save']);
			//登録処理
			if ($this->MenuFrameSetting->saveMenuFrameSetting($this->request->data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl());
			}
			$this->NetCommons->handleValidationError($this->MenuFrameSetting->validationErrors);

		} else {
			$this->request->data = Hash::merge($this->request->data,
				$this->MenuFrameSetting->getMenuFrameSetting()
			);

			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Menus'] = $this->viewVars['menus'];
			$this->request->data['MenuRooms'] = $this->MenuFramesRoom->getMenuFrameRooms(array(
				'conditions' => array($this->Room->alias . '.id' => $roomIds)
			));
		}

		//Treeリスト取得
		$pageTreeList = $this->Page->generateTreeList(
				array('Page.room_id' => $roomIds), null, null, Page::$treeParser);
		$this->set('pageTreeList', $pageTreeList);
	}

}
