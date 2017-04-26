<?php
/**
 * main index template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

if ($nest === 0) {
	$isRootActive = in_array($pageId, $this->Menu2->parentPageIds, true);
	if ($isActive || $isRootActive) {
		if ($hasChild) {
			$listTagStart = '<li role="presentation" class="dropdown active">';
		} else {
			$listTagStart = '<li class="active">';
		}
	} else {
		if ($hasChild) {
			$listTagStart = '<li role="presentation" class="dropdown">';
		} else {
			$listTagStart = '<li>';
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
