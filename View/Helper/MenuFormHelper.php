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
		list($prefixInput, $isHidden, $html) = $this->_getRoomPrefix($roomId, $room);

		$childPageIds = [];
		$childPageIds = $this->getRecursiveChildPageId($pageId, $childPageIds);
		$domChildPageIds = [];
		foreach ($childPageIds as $childPageId) {
			$childRoomId = $this->_View->viewVars['pages'][$childPageId]['Page']['room_id'];
			$domChildPageIds[] = $this->domId(
				'Menus.' . $childRoomId . '.' . $childPageId . '.MenuFramesPage.is_hidden'
			);
		}

		$html .= $this->NetCommonsForm->checkbox($prefixInput . '.' . $isHidden, array(
			'div' => false,
			'value' => '0',
			'hiddenField' => '1',
			'checked' => ! Hash::get($this->_View->request->data, $prefixInput . '.' . $isHidden, false),
			'ng-click' => 'disableChildPages($event, ' . json_encode($domChildPageIds) . ')',
		));
		$name = '';
		foreach ($room['RoomsLanguage'] as $room) {
			if ($room['language_id'] == Current::read('Language.id')) {
				$name = $room['name'];
				break;
			}
		}
		$html .= $this->NetCommonsForm->label(
			$prefixInput . '.' . $isHidden, h($name)
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
		if ($room['Room']['parent_id'] === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID) ||
				$menu['Page']['room_id'] !== Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID) &&
					! $menu['Page']['parent_id']) {

			return $html;
		}
		if ($menu['Page']['id'] === Page::PUBLIC_ROOT_PAGE_ID) {
			return $html;
		}

		list($roomPrefixInput, $roomIsHidden, ) = $this->_getRoomPrefix($rootRoomId, $rootRoom);
		$roomDisabled = Hash::get($this->_View->request->data, $roomPrefixInput)[$roomIsHidden] ?? null;

		$prefixInput = 'Menus.' . $roomId . '.' . $pageId . '.MenuFramesPage';

		//ページ名のネスト
		$nest = substr_count(
			$this->_View->viewVars['pageTreeList'][$pageId], Page::$treeParser
		);
		$nest--;

		$childPageIds = [];
		$childPageIds = $this->getRecursiveChildPageId($pageId, $childPageIds);
		$domChildPageIds = [];
		foreach ($childPageIds as $childPageId) {
			$childRoomId = $this->_View->viewVars['pages'][$childPageId]['Page']['room_id'];
			$domChildPageIds[] = $this->domId(
				'Menus.' . $childRoomId . '.' . $childPageId . '.MenuFramesPage.is_hidden'
			);
		}

		$html .= $this->_View->element('Menus.MenuFrameSettings/page_setting_list', array(
			'menu' => $menu,
			'prefixInput' => $prefixInput,
			'pageId' => $pageId,
			'nest' => $nest,
			//'displayWhenClicking' => $menu['Page']['lft'] + 1 !== (int)$menu['Page']['rght'],
			'displayWhenClicking' => (bool)$menu['Page']['child_count'],
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
 * @return array ページID配列
 */
	public function getRecursiveChildPageId($pageId, $result) {
		if (isset($this->_View->viewVars['pages'][$pageId]['ChildPage'])) {
			foreach ($this->_View->viewVars['pages'][$pageId]['ChildPage'] as $childPage) {
				if (isset($childPage['id'])) {
					$result[] = $childPage['id'];
					$result = $this->getRecursiveChildPageId($childPage['id'], $result);
				}
			}
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
		if ($room['Room']['parent_id'] === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID)) {
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

			$prefixInput = 'MenuRooms.' . $roomId . '.MenuFramesRoom';
			$html .= $this->NetCommonsForm->hidden($prefixInput . '.id');
			$html .= $this->NetCommonsForm->hidden($prefixInput . '.frame_key',
					array('value' => $this->_View->request->data['Frame']['key']));
			$html .= $this->NetCommonsForm->hidden(
				$prefixInput . '.page_id_top', array('value' => $pageIdTop)
			);
			$html .= $this->NetCommonsForm->hidden(
				$prefixInput . '.room_id', array('value' => $roomId)
			);

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
 * @return string CSSクラス名
 */
	protected function _getPageNameCss($room, $pageId) {
		$page = $this->_View->viewVars['pages'][$pageId];
		if ($room['Room']['page_id_top'] === $pageId &&
				$page['Page']['room_id'] !== Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID)) {
			$pageNameCss = 'menu-tree-room';
		} elseif (isset($page['ChildPage'])) {
			$pageNameCss = 'menu-tree-node-page';
		} else {
			$pageNameCss = 'menu-tree-leaf-page';
		}

		return $pageNameCss;
	}

}
