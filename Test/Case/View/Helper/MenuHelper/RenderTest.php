<?php
/**
 * MenuHelper::render()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * MenuHelper::render()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Helper\MenuHelper
 */
class MenuHelperRenderTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.menus.menu_frame_setting',
		'plugin.menus.menu_frames_page',
		'plugin.menus.menu_frames_room',
		'plugin.menus.page4menu',
		'plugin.menus.pages_language4menu',
		'plugin.rooms.room',
		'plugin.rooms.rooms_language4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'menus';

/**
 * viewVarsのデータ取得
 *
 * @return array
 */
	private function __getViewVars() {
		$MenuFrameSetting = ClassRegistry::init('Menus.MenuFrameSetting');
		$MenuFramesRoom = ClassRegistry::init('Menus.MenuFramesRoom');
		$MenuFramesPage = ClassRegistry::init('Menus.MenuFramesPage');
		$Page = ClassRegistry::init('Pages.Page');

		$roomIds = array('2', '5', '6');

		$viewVars = array();
		$viewVars['menus'] = $MenuFramesPage->getMenuData(array(
			'conditions' => array('Page.room_id' => $roomIds)
		));
		$viewVars['menuFrameSetting'] = $MenuFrameSetting->getMenuFrameSetting();
		$menuFrameRooms = $MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array('Room.id' => $roomIds)
		));
		$viewVars['menuFrameRooms'] = Hash::combine($menuFrameRooms, '{n}.Room.id', '{n}');
		$viewVars['pageTreeList'] = $Page->generateTreeList(
				array('Page.room_id' => $roomIds), null, null, Page::$treeParser);
		$viewVars['pages'] = $Page->getPages($roomIds);
		$viewVars['parentPages'] = $Page->getPath(Current::read('Page.id'));

		return $viewVars;
	}

/**
 * checkboxMenuFramesPage()のテストのDataProvider
 *
 * ### 戻り値
 *  - curPageId カレントのページID
 *  - curPermalink カレントのパーマリンク
 *  - parentPageIds 親ページID
 *  - listTag リストタグをつけるかどうか
 *  - active アクティブタグ
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('curPageId' => '9', 'curPermalink' => 'page_1', 'parentPageIds' => array('1', '9'),
				'listTag' => false, 'active' => ' active'),
			array('curPageId' => '9', 'curPermalink' => 'page_1', 'parentPageIds' => array('1', '9'),
				'listTag' => true, 'active' => ' active'),
			array('curPageId' => '5', 'curPermalink' => 'test2', 'parentPageIds' => array('3', '5'),
				'listTag' => false, 'active' => ''),
			array('curPageId' => '5', 'curPermalink' => 'test2', 'parentPageIds' => array('3', '5'),
				'listTag' => true, 'active' => ''),
			array('curPageId' => '11', 'curPermalink' => 'page_3', 'parentPageIds' => array('1', '9', '11'),
				'listTag' => false, 'active' => ''),
			array('curPageId' => '11', 'curPermalink' => 'page_3', 'parentPageIds' => array('1', '9', '11'),
				'listTag' => true, 'active' => ''),
		);
	}

/**
 * render()のテスト
 *
 * @param int $curPageId カレントのページID
 * @param string $curPermalink カレントのパーマリンク
 * @param array $parentPageIds 親ページID
 * @param bool $listTag リストタグをつけるかどうか
 * @param string $active アクティブタグ
 * @dataProvider dataProvider
 * @return void
 */
	public function testRender($curPageId, $curPermalink, $parentPageIds, $listTag, $active) {
		//データ生成
		Current::write('Page.id', $curPageId);
		Current::write('Page.permalink', $curPermalink);
		if (in_array($curPageId, ['9', '11'], true)) {
			$icon = 'glyphicon-menu-down';
		} else {
			$icon = 'glyphicon-menu-right';
		}

		//Helperロード
		$viewVars = $this->__getViewVars();
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->parentPageIds = $parentPageIds;
		$menu = Hash::get($viewVars['menus']['2'], '9');
		$result = $this->Menu->render($menu, $listTag);

		//チェック
		$pageId = '9';
		$permalink = 'page_1';
		$pageName = 'Page 1';
		if ($listTag) {
			$pattern =
				'<li class="' . trim($active) . '">' .
					'<a href="/' . $permalink . '" class="menu-tree-0" id="MenuFramesPage' . $pageId . '">' .
						'<span class="glyphicon ' . $icon . '"> </span> ' . $pageName .
					'</a>' .
				'</li>';
		} else {
			$pattern =
				'<a href="/' . $permalink . '" class="list-group-item menu-tree-0' . $active . '" id="MenuFramesPage' . $pageId . '">' .
					'<span class="glyphicon ' . $icon . '"> </span> ' . $pageName .
				'</a>';
		}
		$this->assertTextContains($pattern, $result);
	}

/**
 * render()のテスト(隠しページ)
 *
 * @return void
 */
	public function testRenderPageHidden() {
		//データ生成
		Current::write('Page.id', '9');
		Current::write('Page.permalink', 'page_1');

		//Helperロード
		$viewVars = $this->__getViewVars();
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->parentPageIds = array('1', '9');
		$menu = Hash::get($viewVars['menus']['2'], '9');
		$menu['MenuFramesPage']['is_hidden'] = true;
		$result = $this->Menu->render($menu, true);

		//チェック
		$this->assertEmpty($result);
	}

/**
 * render()のテスト(プライベートルームの非表示)
 *
 * @return void
 */
	public function testRenderPrivateRoomHidden() {
		//データ生成
		Current::write('Page.id', '9');
		Current::write('Page.permalink', 'page_1');

		//Helperロード
		$viewVars = $this->__getViewVars();
		$viewVars['menuFrameRooms']['10']['Room'] = array(
			'id' => '10',
			'parent_id' => '3',
		);
		$viewVars['menuFrameSetting']['MenuFrameSetting']['is_private_room_hidden'] = true;
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->parentPageIds = array('1', '9');
		$menu = Hash::get($viewVars['menus']['2'], '9');
		$menu['Page']['room_id'] = '10';
		$result = $this->Menu->render($menu, true);

		//チェック
		$this->assertEmpty($result);
	}

/**
 * render()のテスト(ルームの非表示)
 *
 * @return void
 */
	public function testRenderRoomHidden() {
		//データ生成
		Current::write('Page.id', '9');
		Current::write('Page.permalink', 'page_1');

		//Helperロード
		$viewVars = $this->__getViewVars();
		$viewVars['menuFrameRooms']['2']['MenuFramesRoom']['is_hidden'] = true;
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->parentPageIds = array('1', '9');
		$menu = Hash::get($viewVars['menus']['2'], '9');
		$result = $this->Menu->render($menu, true);

		//チェック
		$this->assertEmpty($result);
	}

/**
 * render()のテスト(パブリックスペースのページ)
 *
 * @return void
 */
	public function testRenderPublicSpacePage() {
		//データ生成
		Current::write('Page.id', '9');
		Current::write('Page.permalink', 'page_1');

		//Helperロード
		$viewVars = $this->__getViewVars();
		$requestData = array();
		$params = array();
		$this->loadHelper('Menus.Menu', $viewVars, $requestData, $params);

		//テスト実施
		$this->Menu->parentPageIds = array('1', '9');
		$menu = Hash::get($viewVars['menus']['2'], '1');
		$result = $this->Menu->render($menu, true);

		//チェック
		$this->assertEmpty($result);
	}

}
