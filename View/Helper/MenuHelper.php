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
	public $helpers = array(
		'NetCommonsHtml'
	);

/**
 * メニューの表示
 *
 * @return string HTMLタグ
 */
	public function render() {
		$html = '';
		$displayType = $this->_View->viewVars['menuFrameSetting']['MenuFrameSetting']['display_type'];

		//スタイルシートの読み込み
		$html .= $this->NetCommonsHtml->css('/menus/css/style.css');
		$cssPath = App::pluginPath($this->plugin) . DS . WEBROOT_DIR . DS . 'css' . DS . $displayType . DS . 'style.css';
		if (file_exists($cssPath)) {
			$html .= $this->NetCommonsHtml->css('/menus/css/' . $displayType . '/style.css');
		}
		//JSの読み込み
		$jsPath = App::pluginPath($this->plugin) . DS . WEBROOT_DIR . DS . 'js' . DS . $displayType . DS . 'menus.js';
		if (file_exists($jsPath)) {
			$html .= $this->NetCommonsHtml->script('/menus/js/' . $displayType . '/menus.js');
		}

		//メニューHTML表示
		$html .= '<nav>';
		$html .= $this->_View->element('Menus.Menus/' . $displayType . '/index');
		$html .= '</nav>';

		return $html;
	}

/**
 * メニューリストの表示
 *
 * @param array $menus メニューリスト
 * @param bool $listTag リストタグの有無
 * @return string HTMLタグ
 */
	public function renderList($menus, $listTag) {
		$html = '';
		foreach ($menus as $menu) {
			if ($menu['MenuFramesPage']['is_hidden']) {
				continue;
			}

			if (Current::read('Page.permalink') === (string)$menu['Page']['slug']) {
				$activeClass = 'active';
			} else {
				$activeClass = '';
			}

			$class = '';
			if ($listTag) {
				$html .= '<li class="' . $activeClass . '">';
			} else {
				$class .= 'list-group-item';
			}

			$html .= $this->link($menu, $class . ' ' . $activeClass);

			if ($listTag) {
				$html .= '</li>';
			}
		}

		return $html;
	}

/**
 * メニューリストの表示
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
			$url .= h($menu['Page']['slug']);
		} else {
			$url .= '';
		}

		if ($menu['Page']['id'] === $room['Room']['page_id_top'] && $room['Room']['space_id'] !== Space::PUBLIC_SPACE_ID) {
			$title = Hash::get($room, 'RoomsLanguage.name');
		} else {
			$title = $menu['LanguagesPage']['name'];
		}

		return $this->NetCommonsHtml->link($title, '/' . $url, array('class' => $class));
	}

}
