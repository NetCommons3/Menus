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
App::uses('Space', 'Rooms.Model');

/**
 * Menus Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Controller
 */
class MenusController extends MenusAppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Menus.MenuFrameSetting',
		'Menus.MenuFramesPage',
		'Menus.MenuFramesRoom',
		'Pages.Page',
		'Rooms.Room',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Menus.Menu'
	);

/**
 * indexアクション
 *
 * @return void
 */
	public function index() {
		//ルームデータ取得
		$roomIds = array_keys($this->viewVars['rooms']);

		//メニュー設定データ取得
		$menuFrameSetting = $this->MenuFrameSetting->getMenuFrameSetting();
		$this->set('menuFrameSetting', $menuFrameSetting);

		//ルームデータ取得処理
		$menuFrameRooms = $this->MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array(
				$this->Room->alias . '.id' => $roomIds
			)
		));
		$this->set('menuFrameRooms', Hash::combine($menuFrameRooms, '{n}.Room.id', '{n}'));

		$pages = $this->Page->getPages($roomIds);
		$this->set('pages', $pages);

		$parentPages = $this->Page->getPath(Current::read('Page.id'));
		$this->set('parentPages', $parentPages);

		//メニューデータの有無
		$count1 = $this->MenuFramesRoom->find('count', array('recursive' => -1,
			'conditions' => array(
				$this->MenuFramesRoom->alias . '.frame_key' => Current::read('Frame.key')
			)
		));
		$count2 = $this->MenuFramesPage->find('count', array('recursive' => -1,
			'conditions' => array(
				$this->MenuFramesPage->alias . '.frame_key' => Current::read('Frame.key')
			)
		));

		if ($count1 && $count2) {
			$options = array(
				MenuFrameSetting::DISPLAY_TYPE_HEADER,
				MenuFrameSetting::DISPLAY_TYPE_FOOTER,
			);
		} else {
			$options = array();
		}

		$displayType = $menuFrameSetting['MenuFrameSetting']['display_type'];
		$defaultHidden = in_array($displayType, $options, true);
		$this->set('defaultHidden', $defaultHidden);
		if ($displayType == MenuFrameSetting::DISPLAY_TYPE_PATH) {
			$this->set('glyphiconHiddenHidden', true);
		}

		$this->_setTreeListForDisplay();
	}

/**
 * 表示するページのTree
 *
 * @return void
 */
	protected function _setTreeListForDisplay() {
		$roomIds = array_keys($this->viewVars['rooms']);

		//Treeリスト取得
		$conditions = array(
			'Page.room_id' => $roomIds,
		);
		$dbPageTreeList = $this->Page->generateTreeList($conditions, null, null, Page::$treeParser);

		$parentPages = $this->Page->getPath(Current::read('Page.id'));
		$parentPageIds = Hash::extract($parentPages, '{n}.Page.id');

		$treeList4Disp = []; //表示ツリー用の変数
		$treeChildList = []; //子(孫)ページを表示するかどうか保持す変数
		$pageTreeList = []; //隠しページを除いたツリー用の変数

		$pages = $this->viewVars['pages'];
		$menus = $this->viewVars['menus'];
		foreach ($dbPageTreeList as $pageId => $treePageId) {
			$page = Hash::get($pages, $pageId);
			$menu = Hash::get($menus, $page['Room']['id'] . '.' . $pageId);

			//最初のノードは、必ず表示する。そのため、インデント数で判断する
			$indent = $this->_getIndent($page, $treePageId);

			//隠しページは表示しない
			if ($menu['MenuFramesPage']['is_hidden']) {
				continue;
			}

			$pageTreeList[$pageId] = $treePageId;

			//以下の場合、表示しない
			// * プライベートを表示しない設定になっている
			// * ルームが表示しない設定になっている
			if (! $this->_showPrivateRoom($menu) && ! $this->_showRoom($menu)) {
				continue;
			}

			//以下の条件の時、表示する
			// * 先頭のページなら、必ず表示するものとする
			// * 現在表示しているページの親ページ
			// * 現在いるページの下層ページ(子ページ)なら表示する
			// * クリック時の表示が下層ページなら表示する

			//以下の条件の時、下層ページデータを取得して、次ループで当処理に入ってくるようにデータを保持する
			// * クリック時下層ページを表示
			// * 現在表示しているページの親ページ

			if (in_array((string)$pageId, $parentPageIds, true)) {
				$treeList4Disp[$pageId] = $treePageId;

				//ページの下層ページIDs
				$treeChildList = Hash::merge(
					$treeChildList,
					Hash::extract($pages, $pageId . '.ChildPage.{n}.id', [])
				);
				continue;
			}

			if ($indent === 0 ||
					in_array((string)$pageId, $treeChildList, true)) {
				$treeList4Disp[$pageId] = $treePageId;

				//以下の条件の時、下層ページデータを取得して、次ループで当処理に入ってくるようにデータを保持する
				// * クリック時下層ページを表示
				// * 現在表示しているページの親ページ
				if (Hash::get($menu, 'MenuFramesPage.folder_type')) {
					//ページの下層ページIDs
					$treeChildList = Hash::merge(
						$treeChildList,
						Hash::extract($pages, $pageId . '.ChildPage.{n}.id', [])
					);
				}
			}
		}

		$this->set('treeList4Disp', $treeList4Disp);
		$this->set('pageTreeList', $pageTreeList);
	}

/**
 * インデント数の取得
 *
 * @param array $page ページデータ配列
 * @param string $treePageId Tree(Tabコード付き)のページID
 * @return int
 */
	protected function _getIndent($page, $treePageId) {
		$indent = substr_count($treePageId, Page::$treeParser);
		if ($page['Space']['id'] === Space::PUBLIC_SPACE_ID) {
			$indent--;
		}
		if ($indent < 0) {
			$indent = 0;
		}

		return $indent;
	}

/**
 * プライベートルームを表示するかどうか
 *
 * @param array $menu メニューデータ配列
 * @return bool
 */
	protected function _showPrivateRoom($menu) {
		$defaultHidden = Hash::get($this->viewVars, 'defaultHidden', false);
		$room = Hash::get($this->viewVars['menuFrameRooms'], $menu['Page']['room_id'] . '.Room');
		if ($room['parent_id'] !== Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID)) {
			return false;
		}

		$pathKey = 'MenuFrameSetting.is_private_room_hidden';
		if (Hash::get($this->viewVars['menuFrameSetting'], $pathKey)) {
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
	protected function _showRoom($menu) {
		$defaultHidden = Hash::get($this->viewVars, 'defaultHidden', false);
		$room = Hash::get($this->viewVars['menuFrameRooms'], $menu['Page']['room_id'] . '.Room');
		if ($room['parent_id'] === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID)) {
			return false;
		}
		$menuFrameRooms = Hash::get($this->viewVars['menuFrameRooms'], $room['id'], array());
		if (Hash::get($menuFrameRooms, 'MenuFramesRoom.is_hidden') ||
				$defaultHidden && ! Hash::get($menuFrameRooms, 'MenuFramesRoom.id')) {
			return false;
		}
		if ($defaultHidden && ! $menu['MenuFramesPage']['id']) {
			return false;
		}
		return true;
	}

}
