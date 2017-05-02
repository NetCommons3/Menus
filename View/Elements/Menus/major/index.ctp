<?php
/**
 * リスト表示タイプのメニュー
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo '<div class="list-group">';
$first = true;
foreach ($treeList4Disp as $treePageId) {
	$treeIndent = substr_count($treePageId, Page::$treeParser);
	if ($treeIndent === 0) {
		if (! $first) {
			echo '</div>';
			echo '<div class="list-group">';
		}
		$first = false;
	}

	echo $this->Menu->renderPage($treePageId, 'major');
}
echo '</div>';
