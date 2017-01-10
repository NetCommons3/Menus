<?php
/**
 * View/Elements/Menus/footer/indexのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Menus/footer/indexのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Elements\Menus\footer\Index
 */
class MenusViewElementsMenusFooterIndexTest extends NetCommonsControllerTestCase {

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
		'plugin.pages.frame4pages',
		'plugin.pages.room4pages',
		'plugin.rooms.rooms_language4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'menus';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Menus', 'TestMenus');
		//テストコントローラ生成
		$this->generateNc('TestMenus.TestViewElementsMenusFooterIndex');
	}

/**
 * View/Elements/Menus/footer/indexのテスト
 *
 * @return void
 */
	public function testIndex() {
		$frameId = '4';
		Current::write('Page.id', '4');
		Current::write('Page.permalink', 'home');

		//テスト実行
		$this->_testGetAction('/test_menus/test_view_elements_menus_footer_index/index?frame_id=' . $frameId,
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Menus/footer/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '<ul class="list-group nav nav-pills">';
		$this->assertTextContains($pattern, $this->view);

		$this->__assertLink($frameId, '4', '/', 'active', 'Home ja');
		$this->__assertLink($frameId, '8', '/test5', '', 'Test page 5');
		$this->__assertLink($frameId, '9', '/page_1', '', '<span class="glyphicon glyphicon-menu-right"> <\/span> Page 1');
		$this->__assertLink($frameId, '10', '/page_2', '', 'Page 2');
		$this->__assertLink($frameId, '5', '/test2', '', 'サブルーム１');
		$this->__assertLink($frameId, '6', '/test3', '', 'サブルーム２');
	}

/**
 * メニューリンクのチェック
 *
 * @param int $frameId フレームID
 * @param int $pageId ページID
 * @param string $permalink パーマリンク
 * @param string $active activeかどうか(アクティブの場合、"active"の文字列をセットする)
 * @param string $name ページ名
 * @return void
 */
	private function __assertLink($frameId, $pageId, $permalink, $active, $name) {
		$domId = 'MenuFramesPage' . $frameId . $pageId;
		if ($active) {
			$pattern =
				'<li class="' . $active . '">' .
					'<a href=".*?' . preg_quote($permalink, '/') . '" id="' . $domId . '" class="list-group-item menu-tree-0">' .
						$name .
					'<\/a>' .
				'<\/li>';
		} else {
			$pattern =
				'<li>' .
					'<a href=".*?' . preg_quote($permalink, '/') . '" id="' . $domId . '" class="list-group-item menu-tree-0">' .
						$name .
					'<\/a>' .
				'<\/li>';
		}
		$this->assertRegExp('/' . $pattern . '/', $this->view);
	}

}
