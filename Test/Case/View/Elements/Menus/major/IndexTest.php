<?php
/**
 * View/Elements/Menus/major/indexのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Menus/major/indexのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Case\View\Elements\Menus\major\Index
 */
class MenusViewElementsMenusMajorIndexTest extends NetCommonsControllerTestCase {

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
		'plugin.pages.frame_public_language4pages',
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
		$this->generateNc('TestMenus.TestViewElementsMenusMajorIndex');
	}

/**
 * View/Elements/Menus/major/indexのテスト
 *
 * @return void
 */
	public function testIndex() {
		$frameId = '2';

		//テスト実行
		$this->_testGetAction('/test_menus/test_view_elements_menus_major_index/index?frame_id=' . $frameId,
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Menus/major/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '<div class="list-group">';
		$this->assertTextContains($pattern, $this->view);

		$pattern = '<div class="list-group">';
		$pattern .= $this->__getPattern($frameId, '4', '/', ' active', 'Home ja');
		$pattern .= $this->__getPattern($frameId, '8', '/test5', '', 'Test page 5');
		$pattern .= $this->__getPattern($frameId, '9', '/page_1', '', 'Page 1', '<span class="glyphicon glyphicon-menu-right"> <\/span> ');
		$pattern .= $this->__getPattern($frameId, '10', '/page_2', '', 'Page 2');
		$pattern .= '<\/div>';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<div class="list-group">';
		$pattern .= $this->__getPattern($frameId, '5', '/test2', '', 'サブルーム１');
		$pattern .= '<\/div>';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<div class="list-group">';
		$pattern .= $this->__getPattern($frameId, '6', '/test3', '', 'サブルーム２');
		$pattern .= '<\/div>';
		$this->assertRegExp('/' . $pattern . '/', $this->view);
	}

/**
 * メニューリンクのパターン
 *
 * @param int $frameId フレームID
 * @param int $pageId ページID
 * @param string $permalink パーマリンク
 * @param string $active activeかどうか(アクティブの場合、"active"の文字列をセットする)
 * @param string $name ページ名
 * @param string $icon アイコン
 * @return string パターン
 */
	private function __getPattern($frameId, $pageId, $permalink, $active, $name, $icon = '') {
		$domId = 'MenuFramesPageMajor' . $frameId . $pageId;
		return '<a href=".*?' . preg_quote($permalink, '/') . '" id="' . $domId . '" class="list-group-item clearfix menu-tree-0' . $active . '">' .
					'<span class="pull-left">' . $name . '<\/span>' .
					'<span class="pull-right">' . $icon . '<\/span>' .
				'<\/a>';
	}

}
