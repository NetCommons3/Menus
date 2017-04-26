<?php
/**
 * 下層ページのみ表示タイプのメニュー
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo '<div class="list-group">';

$isActiveRoot = false;
foreach ($pageTreeList2 as $treePageId) {
	$pageId = trim($treePageId);

	$nest = $this->Menu2->getIndent($treePageId);
	if ($nest === 0) {
		$isActiveRoot = in_array($pageId, $this->Menu2->parentPageIds, true);
	}

	if ($isActiveRoot) {
		echo $this->Menu2->renderPage($treePageId);
	}
}

echo '</div>';
