<?php
/**
 * タブ(nav-tabs)表示タイプのメニュー
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

if ($nest === 0 && $hasChild) {
	$listTagEnd = '</li></ul></li>';
} else {
	$listTagEnd = '</li>';
}

echo $listTagEnd;
