<?php
/**
 * MenuHelper
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
 * MenuHelper
 *
 */
class MenuHelper extends AppHelper {

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
 * メニューの表示
 *
 * @return string HTMLタグ
 */
	public function renderMain() {
		$html = '';
		$displayType = $this->_View->viewVars['menuFrameSetting']['MenuFrameSetting']['display_type'];

		//スタイルシートの読み込み
		//$html .= $this->NetCommonsHtml->css('/menus/css/style.css');
		$cssPath = App::pluginPath($this->plugin) . DS . WEBROOT_DIR . DS . 'css' . DS . $displayType . DS . 'style.css';
		if (file_exists($cssPath)) {
			$html .= $this->NetCommonsHtml->css('/menus/css/' . $displayType . '/style.css');
		}
		//JSの読み込み
		$jsPath = App::pluginPath($this->plugin) . DS . WEBROOT_DIR . DS . 'js' . DS . $displayType . DS . 'menus.js';
		if (file_exists($jsPath)) {
			$html .= $this->NetCommonsHtml->script('/menus/js/' . $displayType . '/menus.js');
		}

		$this->parentPageIds = Hash::extract($this->_View->viewVars['parentPages'], '{n}.Page.id', array());
		if (! in_array(Current::read('Page.id'), $this->parentPageIds, true)) {
			$this->parentPageIds[] = Current::read('Page.id');
		}

		//メニューHTML表示
		$html .= '<nav ng-controller="MenusController">';
		$html .= $this->_View->element('Menus.Menus/' . $displayType . '/index');
		$html .= '</nav>';

		return $html;
	}

/**
 * メニューの表示
 *
 * @param int $roomId Room.id
 * @param int $pageId Page.id
 * @param bool $listTag リストタグの有無
 * @return string HTMLタグ
 */
	public function renderChild($roomId, $pageId, $listTag) {
		$html = '';

		$childPageIds = Hash::extract($this->_View->viewVars['pages'], $pageId . '.ChildPage.{n}.id', array());
		$prefixInput = $roomId . '.' . $pageId . '.MenuFramesPage.folder_type';
		if (! Hash::get($this->_View->viewVars['menus'], $prefixInput, false) && ! in_array($pageId, $this->parentPageIds, true)) {
			return $html;
		}

		foreach ($childPageIds as $childPageId) {
			$html .= $this->render(Hash::get($this->_View->viewVars['menus'], $roomId . '.' . $childPageId), $listTag);
			$html .= $this->renderChild($roomId, $childPageId, $listTag);
		}

		return $html;
	}

/**
 * メニューリストの表示
 *
 * @param array $menu メニューデータ配列
 * @param bool $listTag リストタグの有無
 * @return string HTMLタグ
 */
	public function render($menu, $listTag) {
		$html = '';
		if ($menu['MenuFramesPage']['is_hidden']) {
			return $html;
		}
		$roomId = Hash::get($this->_View->viewVars['menuFrameRooms'], $menu['Page']['room_id'] . '.Room.id');
		if (Hash::get($this->_View->viewVars['menuFrameRooms'], $roomId . '.Room.parent_id') === Room::PRIVATE_PARENT_ID &&
				Hash::get($this->_View->viewVars['menuFrameSetting'], 'MenuFrameSetting.is_private_room_hidden')) {
			return $html;
		}
		if (Hash::get($this->_View->viewVars['menuFrameRooms'], $roomId . '.MenuFramesRoom.is_hidden')) {
			return $html;
		}

		if (Current::read('Page.permalink') === (string)$menu['Page']['permalink']) {
			$activeClass = ' active';
		} else {
			$activeClass = '';
		}

		$class = '';
		if ($listTag) {
			$html .= '<li class="' . trim($activeClass) . '">';
			$activeClass = '';
		} else {
			$class .= ' list-group-item';
		}

		$nest = substr_count(Hash::get($this->_View->viewVars['pageTreeList'], $menu['Page']['id']), Page::$treeParser);
		$class .= ' menu-tree-' . $nest;

		$html .= $this->link($menu, trim($class) . $activeClass);

		if ($listTag) {
			$html .= '</li>';
		}

		return $html;
	}

/**
 * リンクの表示
 *
 * @param array $menu リンクデータ
 * @param string $class CSS定義
 * @return string HTMLタグ
 */
	public function link($menu, $class) {
		$setting = '';
		if (Current::isSettingMode()) {
			$setting = Current::SETTING_MODE_WORD . '/';
		}
		$room = Hash::get($this->_View->viewVars['menuFrameRooms'], $menu['Page']['room_id']);

		$url = $setting;
		if ($menu['Page']['slug'] != '') {
			$url .= h($menu['Page']['permalink']);
		} else {
			$url .= '';
		}

		$title = '';
		$html = '';
		if ($menu['Page']['id'] === $room['Room']['page_id_top'] && $menu['Page']['permalink']) {
			$title .= h(Hash::get($room, 'RoomsLanguage.name'));
		} else {
			$title .= h($menu['LanguagesPage']['name']);
		}

		$domId = $this->domId('MenuFramesPage.' . Current::read('Frame.id') . '.' . $menu['Page']['id']);
		$domIdIcon = $domId . 'Icon';
		$options = array('class' => $class, 'id' => $domId, 'escapeTitle' => false);
		$togggle = (int)in_array($menu['Page']['id'], $this->parentPageIds, true);

		if (Hash::get($menu, 'MenuFramesPage.folder_type')) {
			$title = '<span class="glyphicon glyphicon-menu-right"' .
						' ng-class="{\'glyphicon-menu-right\': !' . $domIdIcon . ', \'glyphicon-menu-down\': ' . $domIdIcon . '}"> </span> ' . $title;

			$childPageIds = array();
			$childPageIds = $this->getRecursiveChildPageId($menu['Page']['room_id'], $menu['Page']['id'], $childPageIds);
			$childDomIds = array_map(function ($value) {
				return $this->domId('MenuFramesPage.' . Current::read('Frame.id') . '.' . $value);
			}, $childPageIds);

			$options['ng-init'] = $domIdIcon . '=' . $togggle . '; initialize(\'' . $domId . '\', ' . json_encode($childDomIds) . ', ' . $togggle . ')';
			$options['ng-click'] = $domIdIcon . '=!' . $domIdIcon . ';switchOpenClose(\'' . $domId . '\')';
			$html .= $this->NetCommonsHtml->link($title, '#', $options);

		} elseif (Hash::get($this->_View->viewVars['pages'], $menu['Page']['id'] . '.ChildPage')) {
			if ($togggle) {
				$title = '<span class="glyphicon glyphicon-menu-down"> </span> ' . $title;
			} else {
				$title = '<span class="glyphicon glyphicon-menu-right"> </span> ' . $title;
			}
			$html .= $this->NetCommonsHtml->link($title, '/' . $url, $options);
		} else {
			$html .= $this->NetCommonsHtml->link($title, '/' . $url, $options);
		}

		return $html;
	}

/**
 * ChildPageのIdを取得する(再帰的に)
 *
 * @param int $roomId Room.id
 * @param int $pageId Page.id
 * @param array $result 再帰の結果配列
 * @return string HTMLタグ
 */
	public function getRecursiveChildPageId($roomId, $pageId, $result) {
		$childPageIds = Hash::extract($this->_View->viewVars['pages'], $pageId . '.ChildPage.{n}.id', array());
		foreach ($childPageIds as $childPageId) {
			$result[] = $childPageId;

			$prefixInput = $roomId . '.' . $childPageId . '.MenuFramesPage.folder_type';
			if (! Hash::get($this->_View->viewVars['menus'], $prefixInput, false)) {
				$result = $this->getRecursiveChildPageId($roomId, $childPageId, $result);
			}
		}
		return $result;
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
			'checked' => ! (bool)Hash::get($menu, $prefixInput . '.is_hidden')
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
