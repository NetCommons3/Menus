<?php
/**
 * Menusプラグイン用LanguagesPageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LanguagesPageFixture', 'Pages.Test/Fixture');

/**
 * Menusプラグイン用LanguagesPageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Menus\Test\Fixture
 */
class PagesLanguage4menuFixture extends LanguagesPageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'LanguagesPage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'languages_pages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース自体のページ
		// * 英語
		array('page_id' => '1', 'language_id' => '1', 'name' => ''),
		// * 日本語
		array('page_id' => '1', 'language_id' => '2', 'name' => ''),
		//プライベートスペース自体のページ
		// * 英語
		array('page_id' => '2', 'language_id' => '1', 'name' => ''),
		// * 日本語
		array('page_id' => '2', 'language_id' => '2', 'name' => ''),
		//ルームスペース自体のページ
		// * 英語
		array('page_id' => '3', 'language_id' => '1', 'name' => ''),
		// * 日本語
		array('page_id' => '3', 'language_id' => '2', 'name' => ''),
		//パブリックスペースのホーム
		// * 英語
		array('page_id' => '4', 'language_id' => '1', 'name' => 'Home en'),
		// * 日本語
		array('page_id' => '4', 'language_id' => '2', 'name' => 'Home ja'),
		//ホーム/test4
		// * 英語
		array('page_id' => '7', 'language_id' => '1', 'name' => 'Test page 4'),
		// * 日本語
		array('page_id' => '7', 'language_id' => '2', 'name' => 'Test page 4'),
		//ホーム/test4
		// * 英語
		array('page_id' => '8', 'language_id' => '1', 'name' => 'Test page 5'),
		// * 日本語
		array('page_id' => '8', 'language_id' => '2', 'name' => 'Test page 5'),
		//別ルーム(room_id=4)
		// * 英語
		array('page_id' => '5', 'language_id' => '1', 'name' => 'Test page 2'),
		// * 日本語
		array('page_id' => '5', 'language_id' => '2', 'name' => 'Test page 2'),
		//別ルーム(room_id=5、ブロックなし)
		// * 英語
		array('page_id' => '6', 'language_id' => '1', 'name' => 'Test page 3'),
		// * 日本語
		array('page_id' => '6', 'language_id' => '2', 'name' => 'Test page 3'),

		//page.permalink=page_1
		array('page_id' => '9', 'language_id' => '2', 'name' => 'Page 1'),
		//page.permalink=page_2
		array('page_id' => '10', 'language_id' => '2', 'name' => 'Page 2'),
		//page.permalink=page_1/page_3
		array('page_id' => '11', 'language_id' => '2', 'name' => 'Page 3'),
		//page.permalink=page_1/page_3/page_6
		array('page_id' => '12', 'language_id' => '2', 'name' => 'Page 6'),
	);

}
