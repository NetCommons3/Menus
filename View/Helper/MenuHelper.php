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
 * @param string $displayType 表示タイプ
 * @return string HTMLタグ
 */
	public function renderMain($displayType = null) {
		$html = '';
		if (! $displayType) {
			$displayType = $this->_View->viewVars['menuFrameSetting']['MenuFrameSetting']['display_type'];
		}
		$plugin = Inflector::camelize($this->_View->params['plugin']);

		//スタイルシートの読み込み
		$cssPath = App::pluginPath($plugin) .
					WEBROOT_DIR . DS . 'css' . DS . $displayType . DS . 'style.css';
		if (file_exists($cssPath)) {
			$html .= $this->NetCommonsHtml->css('/menus/css/' . $displayType . '/style.css');
		}
		//JSの読み込み
		$jsPath = App::pluginPath($plugin) .
					WEBROOT_DIR . DS . 'js' . DS . $displayType . DS . 'menus.js';
		if (file_exists($jsPath)) {
			$html .= $this->NetCommonsHtml->script('/menus/js/' . $displayType . '/menus.js');
		}

		$this->parentPageIds = array(Page::PUBLIC_ROOT_PAGE_ID);
		$this->parentPageIds = array_merge(
			$this->parentPageIds,
			Hash::extract($this->_View->viewVars['parentPages'], '{n}.Page.id', array())
		);
		if (! in_array(Current::read('Page.id'), $this->parentPageIds, true)) {
			$this->parentPageIds[] = Current::read('Page.id');
		}
		$this->parentPageIds = array_unique($this->parentPageIds);

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

		$prefixInput = $roomId . '.' . $pageId . '.MenuFramesPage.folder_type';
		if (! Hash::get($this->_View->viewVars['menus'], $prefixInput, false) &&
				! in_array($pageId, $this->parentPageIds, true)) {
			return $html;
		}

		$pageTreeList = array_keys($this->_View->viewVars['pageTreeList']);
		$childPageIds = Hash::extract(
			$this->_View->viewVars['pages'], $pageId . '.ChildPage.{n}.id', array()
		);
		$sortChildPageIds = array();
		foreach ($childPageIds as $id) {
			$index = array_search((int)$id, $pageTreeList, true);
			$sortChildPageIds[$index] = $id;
		}
		ksort($sortChildPageIds);

		foreach ($sortChildPageIds as $childPageId) {
			$childRoomId = Hash::get(
				$this->_View->viewVars['pages'], $childPageId . '.Page.room_id', $roomId
			);
			$html .= $this->render(
				Hash::get($this->_View->viewVars['menus'], $childRoomId . '.' . $childPageId), $listTag
			);
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

		if (! $this->showPrivateRoom($menu) && ! $this->showRoom($menu) ||
				$menu['MenuFramesPage']['is_hidden']) {
			return $html;
		}

		if ($menu['Page']['id'] === Page::PUBLIC_ROOT_PAGE_ID) {
			return $html;
		}

		if (Current::read('Page.permalink') === (string)$menu['Page']['permalink']) {
			$activeClass = ' active';
		} else {
			$activeClass = '';
		}

		$class = '';
		if ($listTag) {
			$listTagStart = '<li class="' . trim($activeClass) . '">';
			$listTagEnd = '</li>';
			$activeClass = '';
		} else {
			$listTagStart = '';
			$listTagEnd = '';
			$class .= ' list-group-item';
		}

		$nest = substr_count(
			Hash::get($this->_View->viewVars['pageTreeList'], $menu['Page']['id']), Page::$treeParser
		);
		if ($menu['Page']['root_id'] === Page::PUBLIC_ROOT_PAGE_ID) {
			$nest--;
		}
		$class .= ' menu-tree-' . $nest;

		$html .= $listTagStart;
		$html .= $this->link($menu, trim($class) . $activeClass);
		$html .= $listTagEnd;

		return $html;
	}

/**
 * プライベートルームを表示するかどうか
 *
 * @param array $menu メニューデータ配列
 * @return bool
 */
	public function showPrivateRoom($menu) {
		$defaultHidden = Hash::get($this->_View->viewVars, 'defaultHidden', false);
		$room = Hash::get($this->_View->viewVars['menuFrameRooms'], $menu['Page']['room_id'] . '.Room');
		if ($room['parent_id'] !== Room::PRIVATE_PARENT_ID) {
			return false;
		}

		$pathKey = 'MenuFrameSetting.is_private_room_hidden';
		if (Hash::get($this->_View->viewVars['menuFrameSetting'], $pathKey)) {
			return false;
		}

		if ($room['page_id_top'] !== $menu['Page']['id'] &&
				$defaultHidden &&
				! $menu['MenuFramesPage']['id']) {
			return false;
		}
		return true;
	}

/**
 * ルームを表示するかどうか
 *
 * @param array $menu メニューデータ配列
 * @return bool
 */
	public function showRoom($menu) {
		$defaultHidden = Hash::get($this->_View->viewVars, 'defaultHidden', false);
		$room = Hash::get($this->_View->viewVars['menuFrameRooms'], $menu['Page']['room_id'] . '.Room');
		if ($room['parent_id'] === Room::PRIVATE_PARENT_ID) {
			return false;
		}
		$menuFrameRooms = Hash::get($this->_View->viewVars['menuFrameRooms'], $room['id'], array());
		if (Hash::get($menuFrameRooms, 'MenuFramesRoom.is_hidden') ||
				$defaultHidden && ! Hash::get($menuFrameRooms, 'MenuFramesRoom.id')) {
			return false;
		}
		if ($defaultHidden && ! $menu['MenuFramesPage']['id']) {
			return false;
		}
		return true;
	}

/**
 * リンクの表示
 *
 * @param array $menu リンクデータ
 * @param string $class CSS定義
 * @return string HTMLタグ
 */
	public function link($menu, $class) {
		$html = '';
		if (! $menu) {
			return $html;
		}

		$setting = '';
		if (Current::isSettingMode()) {
			$setting = Current::SETTING_MODE_WORD . '/';
		}
		$room = Hash::get($this->_View->viewVars['menuFrameRooms'], $menu['Page']['room_id']);

		$url = $setting;
		if ($room['Room']['page_id_top'] === $menu['Page']['id'] &&
				$room['Room']['id'] === Room::PUBLIC_PARENT_ID) {
			$url .= '';
		} else {
			$url .= h($menu['Page']['permalink']);
		}

		$title = $this->__getTitle($menu);
		$domId = $this->domId('MenuFramesPage.' . Current::read('Frame.id') . '.' . $menu['Page']['id']);
		$domIdIcon = $domId . 'Icon';
		$options = array('class' => $class, 'id' => $domId, 'escapeTitle' => false);
		$toggle = (int)in_array($menu['Page']['id'], $this->parentPageIds, true);

		if (Hash::get($menu, 'MenuFramesPage.folder_type')) {
			$childPageIds = array();
			$childPageIds = $this->getRecursiveChildPageId(
				$menu['Page']['room_id'], $menu['Page']['id'], $childPageIds
			);
			$childDomIds = array_map(function ($value) {
				return $this->domId('MenuFramesPage.' . Current::read('Frame.id') . '.' . $value);
			}, $childPageIds);

			$options['ng-init'] = $domIdIcon . '=' . $toggle . ';' .
					' initialize(\'' . $domId . '\', ' . json_encode($childDomIds) . ', ' . $toggle . ')';
			$options['ng-click'] = $domIdIcon . '=!' . $domIdIcon . ';switchOpenClose(\'' . $domId . '\')';
			$html .= $this->NetCommonsHtml->link($title, '#', $options);
		} else {
			$html .= $this->NetCommonsHtml->link($title, '/' . $url, $options);
		}

		return $html;
	}

/**
 * リンクのタイトル表示
 *
 * @param array $menu リンクデータ
 * @return string タイトル
 */
	private function __getTitle($menu) {
		$room = Hash::get($this->_View->viewVars['menuFrameRooms'], $menu['Page']['room_id']);

		$title = '';
		if ($room && Hash::get($room['Room'], 'page_id_top', false) === $menu['Page']['id'] &&
				$room['Room']['id'] !== Room::PUBLIC_PARENT_ID) {
			$title .= h(Hash::get($room, 'RoomsLanguage.name', ''));
		} else {
			$title .= h(Hash::get($menu, 'LanguagesPage.name', ''));
		}

		$domId = $this->domId('MenuFramesPage.' . Current::read('Frame.id') . '.' . $menu['Page']['id']);
		$domIdIcon = $domId . 'Icon';
		$toggle = (int)in_array($menu['Page']['id'], $this->parentPageIds, true);

		if (Hash::get($menu, 'MenuFramesPage.folder_type')) {
			$title = '<span class="glyphicon glyphicon-menu-right"' .
						' ng-class="{' .
							'\'glyphicon-menu-right\': !' . $domIdIcon . ', ' .
							'\'glyphicon-menu-down\': ' . $domIdIcon . '' .
						'}"> ' .
					'</span> ' . $title;

		} elseif (Hash::get($this->_View->viewVars['pages'], $menu['Page']['id'] . '.ChildPage')) {
			if ($toggle) {
				$title = '<span class="glyphicon glyphicon-menu-down"> </span> ' . $title;
			} else {
				$title = '<span class="glyphicon glyphicon-menu-right"> </span> ' . $title;
			}
		}

		return $title;
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
		$childPageIds = Hash::extract(
			$this->_View->viewVars['pages'], $pageId . '.ChildPage.{n}.id', array()
		);
		foreach ($childPageIds as $childPageId) {
			$result[] = $childPageId;

			$prefixInput = $roomId . '.' . $childPageId . '.MenuFramesPage.folder_type';
			if (! Hash::get($this->_View->viewVars['menus'], $prefixInput, false)) {
				$result = $this->getRecursiveChildPageId($roomId, $childPageId, $result);
			}
		}
		return $result;
	}

}
