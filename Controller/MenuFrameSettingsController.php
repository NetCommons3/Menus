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
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('edit'),
			),
		),
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
	);

/**
 * index
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function edit() {
		//登録処理の場合、URLよりPOSTパラメータでチェックする
		if ($this->request->is(array('post', 'put'))) {
			$frameId = $this->data['Frame']['id'];
		} else {
			$frameId = $this->viewVars['frameId'];
		}

		//フレームデータ取得
		$this->request->data = Hash::merge($this->request->data,
			$this->Frame->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $frameId)
			)
		));
		if (! isset($this->request->data['Frame']) || ! $this->request->data['Frame']) {
			$this->autoRender = false;
			return;
		}

		if (isset(PageLayoutHelper::$page)) {
			$roomId = PageLayoutHelper::$page['roomId'];
		} else {
			$roomId = $this->request->data['Frame']['room_id'];
		}

		if ($this->request->is(array('post', 'put'))) {
			//不要パラメータ除去
			$data = $this->data;
			unset($data['save']);

			if ($this->MenuFrameSetting->saveMenuFrameSetting($data)) {
				$this->redirectByFrameId();
				return;
			}

			$this->handleValidationError($this->MenuFrameSetting->validationErrors);
			$this->request->data = $data;

		} else {
			$this->request->data = Hash::merge($this->request->data,
				$this->MenuFrameSetting->find('first', array(
					'recursive' => -1,
					'conditions' => array('frame_key' => $this->request->data['Frame']['key'])
				)
			));

			$this->request->data['Menus'] = $this->MenuFramesPage->getMenuData($roomId, $this->request->data['Frame']['key']);
		}
	}

}
