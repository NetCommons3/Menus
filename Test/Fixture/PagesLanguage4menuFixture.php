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
		//トップページ
		array(
			'id' => '1',
			'page_id' => '1',
			'language_id' => '2',
			'name' => 'Home',
		),
		//page.permalink=page_1
		array(
			'id' => '2',
			'page_id' => '2',
			'language_id' => '2',
			'name' => 'Page 1',
		),
		//page.permalink=page_2
		array(
			'id' => '3',
			'page_id' => '3',
			'language_id' => '2',
			'name' => 'Page 2',
		),
		//page.permalink=page_1/page_3
		array(
			'id' => '4',
			'page_id' => '4',
			'language_id' => '2',
			'name' => 'Page 3',
		),
		//page.permalink=page_1/page_3/page_6
		array(
			'id' => '7',
			'page_id' => '7',
			'language_id' => '2',
			'name' => 'Page 6',
		),
		//別ルーム(room_id=4)
		array(
			'id' => '5',
			'page_id' => '5',
			'language_id' => '2',
			'name' => 'Page 4',
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '6',
			'page_id' => '6',
			'language_id' => '2',
			'name' => 'Page 5',
		),
	);

}
