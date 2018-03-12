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
 * @package NetCommons\Menus\View\Helper
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
 * @param int $pageId Page.id
 * @return string HTMLタグ
 */
	public function checkboxMenuFramesRoom($roomId, $room, $pageId) {
		list($prefixInput, $isFidden, $html) = $this->_getRoomPrefix($roomId, $room);

		$childPageIds = [];
		$childPageIds = $this->getRecursiveChildPageId($pageId, $childPageIds);
		$domChildPageIds = [];
		foreach ($childPageIds as $childPageId) {
			$childRoomId = Hash::get(
				$this->_View->viewVars['pages'], $childPageId . '.Page.room_id'
			);
			$domChildPageIds[] = $this->domId(
				'Menus.' . $childRoomId . '.' . $childPageId . '.MenuFramesPage.is_hidden'
			);
		}

		$html .= $this->NetCommonsForm->checkbox($prefixInput . '.' . $isFidden, array(
			'div' => false,
			'value' => '0',
			'hiddenField' => '1',
			'checked' => ! (bool)Hash::get($this->_View->request->data, $prefixInput . '.' . $isFidden),
			'ng-click' => 'disableChildPages($event, ' . json_encode($domChildPageIds) . ')',
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
 * @param int $roomId ルームID
 * @param array $room ルームデータ
 * @param int $pageId ページID
 * @param array $menu メニューデータ
 * @param int $rootRoomId ルートのルームID
 * @param array $rootRoom ルートのルームデータ
 * @return string HTMLタグ
 */
	public function checkboxMenuFramesPage($roomId, $room, $pageId, $menu, $rootRoomId, $rootRoom) {
		$html = '';
		if (Hash::get($room, 'Room.parent_id') === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID) ||
				Hash::get($menu, 'Page.room_id') !== Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID) &&
					! Hash::get($menu, 'Page.parent_id')) {

			return $html;
		}
		if ($menu['Page']['id'] === Page::PUBLIC_ROOT_PAGE_ID) {
			return $html;
		}

		list($roomPrefixInput, $roomIsFidden, ) = $this->_getRoomPrefix($rootRoomId, $rootRoom);
		$roomDisabled = (bool)Hash::get(
			$this->_View->request->data, $roomPrefixInput . '.' . $roomIsFidden
		);

		$prefixInput = 'Menus.' . $roomId . '.' . $pageId . '.MenuFramesPage';

		//ページ名のネスト
		$nest = substr_count(
			Hash::get($this->_View->viewVars['pageTreeList'], $pageId), Page::$treeParser
		);
		$nest--;

		$childPageIds = [];
		$childPageIds = $this->getRecursiveChildPageId($pageId, $childPageIds);
		$domChildPageIds = [];
		foreach ($childPageIds as $childPageId) {
			$childRoomId = Hash::get(
				$this->_View->viewVars['pages'], $childPageId . '.Page.room_id'
			);
			$domChildPageIds[] = $this->domId(
				'Menus.' . $childRoomId . '.' . $childPageId . '.MenuFramesPage.is_hidden'
			);
		}

		$html .= $this->_View->element('Menus.MenuFrameSettings/page_setting_list', array(
			'menu' => $menu,
			'prefixInput' => $prefixInput,
			'pageId' => $pageId,
			'nest' => $nest,
			'displayWhenClicking' => $menu['Page']['lft'] + 1 !== (int)$menu['Page']['rght'],
			'domChildPageIds' => $domChildPageIds,
			'roomDisabled' => $roomDisabled,
			'pageNameCss' => $this->_getPageNameCss($room, $pageId),
		));

		return $html;
	}

/**
 * ChildPageのIdを取得する(再帰的に)
 *
 * @param int $pageId Page.id
 * @param array $result 再帰の結果配列
 * @return string HTMLタグ
 */
	public function getRecursiveChildPageId($pageId, $result) {
		$childPageIds = Hash::extract(
			$this->_View->viewVars['pages'], $pageId . '.ChildPage.{n}.id', array()
		);
		foreach ($childPageIds as $childPageId) {
			$result[] = $childPageId;
			$result = $this->getRecursiveChildPageId($childPageId, $result);
		}
		return $result;
	}

/**
 * ルームチェックボックスのPrefixを返す
 *
 * @param int $roomId Room.id
 * @param array $room ルームデータ
 * @return array
 */
	protected function _getRoomPrefix($roomId, $room) {
		$html = '';
		if (Hash::get($room, 'Room.parent_id') === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID)) {
			$prefixInput = 'MenuFrameSetting';
			$isFidden = 'is_private_room_hidden';
		} else {
			//$prefixInput = 'MenuRooms.' . $roomId . '.MenuFramesRoom';
			$pageIdTop = $room['Room']['page_id_top'];
			// ページ一覧で、パブリックルームのルーム表示のみ、ページがないため、$room['Room']['page_id_top']から取れない。
			// そのため、Space::getPageIdSpace(Space::PUBLIC_SPACE_ID)で page_idをセット
			if ($roomId === Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID, 'Room')) {
				$pageIdTop = Space::getPageIdSpace(Space::PUBLIC_SPACE_ID);
			}

			$prefixInput = 'Menus.' . $roomId . '.' . $pageIdTop . '.MenuFramesPage';
			$isFidden = 'is_hidden';

			$html .= $this->NetCommonsForm->hidden($prefixInput . '.id');
			$html .= $this->NetCommonsForm->hidden($prefixInput . '.frame_key',
					array('value' => $this->_View->request->data['Frame']['key']));
			$html .= $this->NetCommonsForm->hidden(
				$prefixInput . '.page_id', array('value' => $pageIdTop)
			);
		}
		return array($prefixInput, $isFidden, $html);
	}

/**
 * ページの識別する帯の取得
 *
 * @param array $room ルームデータ
 * @param int $pageId ページID
 * @return array
 */
	protected function _getPageNameCss($room, $pageId) {
		$page = Hash::get($this->_View->viewVars['pages'], $pageId);
		if (Hash::get($room, 'Room.page_id_top') === $pageId &&
				Hash::get($page, 'Page.room_id') !== Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID)) {
			$pageNameCss = 'menu-tree-room';
		} elseif (Hash::get($page, 'ChildPage')) {
			$pageNameCss = 'menu-tree-node-page';
		} else {
			$pageNameCss = 'menu-tree-leaf-page';
		}

		return $pageNameCss;
	}

}
