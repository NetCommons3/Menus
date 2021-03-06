<?php
/**
 * 丸み(nav-pills)表示タイプのメニュー
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('Container', 'Containers.Model');

if (Current::read('PageContainer.container_type') === Container::TYPE_FOOTER) {
	$drop = 'dropup';
} else {
	$drop = 'dropdown';
}

if ($nest === 0) {
	$isRootActive = in_array($pageId, $this->Menu->parentPageIds, true);
	$linkClick = 'linkClick(\'' . $this->Menu->getLinkDomId('footer', $pageId) . '\')';
	if ($isActive || $isRootActive) {
		if ($hasChild) {
			$listTagStart = '<li role="presentation" class="' . $drop . ' active" ng-click="' . $linkClick . '">';
		} else {
			$listTagStart = '<li class="active" ng-click="' . $linkClick . '">';
		}
	} else {
		if ($hasChild) {
			$listTagStart = '<li role="presentation" class="' . $drop . '" ng-click="' . $linkClick . '">';
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
