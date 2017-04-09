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
App::uses('Space', 'Rooms.Model');
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

		if (Hash::get($room, 'Room.parent_id') === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID)) {
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
		$extract = Hash::extract(
			$room, 'RoomsLanguage.{n}[language_id=' . Current::read('Language.id') . ']'
		);
		$html .= $this->NetCommonsForm->label(
			$prefixInput . '.' . $isFidden, h(Hash::get($extract, '0.name'))
		);

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
		if (Hash::get($room, 'Room.parent_id') === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID) ||
				Hash::get($menu, 'Page.room_id') !== Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID) &&
					! Hash::get($menu, 'Page.parent_id')) {

			return $html;
		}
		if ($menu['Page']['id'] === Page::PUBLIC_ROOT_PAGE_ID) {
			return $html;
		}

		$prefixInput = 'Menus.' . $roomId . '.' . $pageId . '.MenuFramesPage';

		//ページ名のネスト
		$nest = substr_count(
			Hash::get($this->_View->viewVars['pageTreeList'], $pageId), Page::$treeParser
		);

		$html .= $this->_View->element('Menus.MenuFrameSettings/page_setting_list', array(
			'menu' => $menu,
			'prefixInput' => $prefixInput,
			'pageId' => $pageId,
			'nest' => $nest,
			'displayWhenClicking' => $menu['Page']['lft'] + 1 !== (int)$menu['Page']['rght']
		));

		return $html;
	}

}
