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

if ($nest === 0) {
	$isRootActive = in_array($pageId, $this->Menu->parentPageIds, true);
	$linkClick = 'linkClick(\'' . $this->Menu->getLinkDomId('header', $pageId) . '\')';
	if ($isActive || $isRootActive) {
		if ($hasChild) {
			$listTagStart = '<li role="presentation" class="dropdown active">';
		} else {
			$listTagStart = '<li class="active" ng-click="' . $linkClick . '">';
		}
	} else {
		if ($hasChild) {
			$listTagStart = '<li role="presentation" class="dropdown">';
		} else {
			$listTagStart = '<li ng-click="' . $linkClick . '">';
		}
	}
} else {
	if ($isActive) {
		$listTagStart = '<li class="active">';
	} else {
		$listTagStart = '<li>';
	}
}

echo $listTagStart;
