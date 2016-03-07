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
		//テスト実行
		$this->_testGetAction('/test_menus/test_view_elements_menus_major_index/index?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Menus/major/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '<div class="list-group">';
		$this->assertTextContains($pattern, $this->view);

		$pattern = '<div class="list-group">';
		$pattern .= $this->__getPattern('6', '1', '/', ' active', 'Home');
		$pattern .= $this->__getPattern('6', '2', '/page_1', '', '<span class="glyphicon glyphicon-menu-right"> <\/span> Page 1');
		$pattern .= $this->__getPattern('6', '3', '/page_2', '', 'Page 2');
		$pattern .= '<\/div>';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<div class="list-group">';
		$pattern .= $this->__getPattern('6', '5', '/page_4', '', 'Page 4');
		$pattern .= '<\/div>';
		$this->assertRegExp('/' . $pattern . '/', $this->view);

		$pattern = '<div class="list-group">';
		$pattern .= $this->__getPattern('6', '6', '/page_5', '', 'Page 5');
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
 * @return string パターン
 */
	private function __getPattern($frameId, $pageId, $permalink, $active, $name) {
		$domId = 'MenuFramesPage' . $frameId . $pageId;
		return '<a href=".*?' . preg_quote($permalink, '/') . '" class="list-group-item menu-tree-0' . $active . '" id="' . $domId . '">' .
					$name .
				'<\/a>';
	}

}
