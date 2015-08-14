<?php
/**
 * Menus All Test Case
 *
 * @copyright    Copyright 2014, NetCommons Project
 * @link          http://www.netcommons.org NetCommons Project
 * @author        Noriko Arai <arai@nii.ac.jp>
 * @author        Shohei Nakajima <nakajimashouhei@gmail.com>
 * @license       http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Menus All Test Case
 *
 * @author        Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package       Menus\Test\Case
 * @codeCoverageIgnore
 */
class AllMenusTest extends CakeTestSuite {

/**
 * All test suite
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);

		$suite = new CakeTestSuite(sprintf('All %s Plugin tests', $plugin));
		$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case');

		return $suite;
	}
}
