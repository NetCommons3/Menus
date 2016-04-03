<?php
/**
 * MenuFormHelper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');
App::uses('Room', 'Rooms.Model');
ClassRegistry::init('Pages.Page');

/**
 * MenuFormHelper
 *
 */
class MenuFormHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $parentPageIds = array();

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->css('/menus/css/style.css');
		$this->NetCommonsHtml->script('/menus/js/menus.js');
		parent::beforeRender($viewFile);
	}

/**
 * MenuFramesRoomのチェックボックス表示
 *
 * @param int $roomId Room.id
 * @param array $room ルームデータ
 * @return string HTMLタグ
 */
	public function checkboxMenuFramesRoom($roomId, $room) {
		$html = '';

		if (Hash::get($room, 'Room.parent_id') === Room::PRIVATE_PARENT_ID) {
			$prefixInput = 'MenuFrameSetting';
			$isFidden = 'is_private_room_hidden';
		} else {
			$prefixInput = 'MenuRooms.' . $roomId . '.MenuFramesRoom';
			$isFidden = 'is_hidden';

			$html .= $this->NetCommonsForm->hidden($prefixInput . '.id');
			$html .= $this->NetCommonsForm->hidden($prefixInput . '.frame_key',
					array('value' => $this->_View->request->data['Frame']['key']));
			$html .= $this->NetCommonsForm->hidden($prefixInput . '.room_id', array('value' => $roomId));
		}

		$html .= $this->NetCommonsForm->checkbox($prefixInput . '.' . $isFidden, array(
			'div' => false,
			'value' => '0',
			'hiddenField' => '1',
			'checked' => ! (bool)Hash::get($this->_View->request->data, $prefixInput . '.' . $isFidden)
		));
		$html .= $this->NetCommonsForm->label($prefixInput . '.' . $isFidden,
				Hash::get(Hash::extract($room, 'RoomsLanguage.{n}[language_id=' . Current::read('Language.id') . ']'), '0.name'));

		return $html;
	}

/**
 * MenuFramesPageのチェックボックス表示
 *
 * @param int $roomId Room.id
 * @param array $room ルームデータ
 * @param int $pageId Page.id
 * @param array $menu メニューデータ
 * @return string HTMLタグ
 */
	public function checkboxMenuFramesPage($roomId, $room, $pageId, $menu) {
		$html = '';
		if (Hash::get($room, 'Room.parent_id') === Room::PRIVATE_PARENT_ID ||
				Hash::get($menu, 'Page.room_id') !== Room::PUBLIC_PARENT_ID && ! Hash::get($menu, 'Page.parent_id')) {
			return $html;
		}
		if ($menu['Page']['id'] === Page::PUBLIC_ROOT_PAGE_ID) {
			return $html;
		}

		$prefixInput = 'Menus.' . $roomId . '.' . $pageId . '.MenuFramesPage';

		$html .= '<li class="list-group-item menu-list-item">';
		$html .= '<div class="row">';

		//フォルダタイプの初期値セット
		$folderTypeDomId = $this->domId($prefixInput . '.folder_type');
		$html .= '<div class="col-xs-9" ng-init="' . $folderTypeDomId . ' = ' . ((int)Hash::get($menu, 'MenuFramesPage.folder_type')) . '">';

		//ページ名のネスト
		$nest = substr_count(Hash::get($this->_View->viewVars['pageTreeList'], $pageId), Page::$treeParser);
		$html .= str_repeat('<span class="menu-edit-tree"> </span>', $nest);

		//MenuFramesPageのinput
		$html .= $this->NetCommonsForm->hidden($prefixInput . '.id');
		$html .= $this->NetCommonsForm->hidden($prefixInput . '.frame_key',
				array('value' => $this->_View->request->data['Frame']['key']));
		$html .= $this->NetCommonsForm->hidden($prefixInput . '.page_id', array('value' => $pageId));
		$html .= $this->NetCommonsForm->checkbox($prefixInput . '.is_hidden', array(
			'div' => false,
			'value' => '0',
			'hiddenField' => '1',
			'checked' => ! (bool)Hash::get($this->_View->request->data, $prefixInput . '.is_hidden')
		));
		$html .= $this->NetCommonsForm->label($prefixInput . '.is_hidden', Hash::get($menu, 'LanguagesPage.name'));

		//フォルダタイプのinput
		if ($menu['Page']['lft'] + 1 !== (int)$menu['Page']['rght']) {
			$html .= $this->NetCommonsForm->button(__d('menus', 'Folder type'), array(
				'type' => 'button',
				'ng-click' => $folderTypeDomId . ' = (' . $folderTypeDomId . ' ? 0 : 1)',
				'class' => 'btn btn-default btn-workflow btn-xs',
				'ng-class' => '{active: ' . $folderTypeDomId . '}',
			));
			$this->NetCommonsForm->unlockField($prefixInput . '.folder_type');
			$html .= $this->NetCommonsForm->hidden($prefixInput . '.folder_type',
					array('ng-value' => $folderTypeDomId));
		}
		$html .= '</div>';

		//ページ移動のボタン(後で)
		$html .= '<div class="col-xs-3">';

		$html .= '</div>';

		$html .= '</div>';
		$html .= '</li>';
		return $html;
	}

}
