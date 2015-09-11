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
App::uses('PageLayoutHelper', 'Pages.View/Helper');

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
			//アクセスの権限
			'allow' => array(
				'edit' => 'block_editable',
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
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesPage',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//フレームなしの場合、
		if (! Current::read('Frame.id')) {
			$this->autoRender = false;
			return;
		}

		if ($this->request->is(array('post', 'put'))) {
			//不要パラメータ除去
			$data = $this->data;
			unset($data['save']);

			if ($this->MenuFrameSetting->saveMenuFrameSetting($data)) {
				$this->redirect(Current::backToPageUrl());
				return;
			}

			$this->NetCommons->handleValidationError($this->MenuFrameSetting->validationErrors);
			$this->request->data = $data;

		} else {
			$this->request->data = Hash::merge($this->request->data,
				$this->MenuFrameSetting->find('first', array(
					'recursive' => -1,
					'conditions' => array('frame_key' => Current::read('Frame.key'))
				)
			));

			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Menus'] = $this->MenuFramesPage->getMenuData();
		}
	}

}
