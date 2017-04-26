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

$title = '';

if ($nest === 0) {
	$hasChild = $this->Menu2->hasChildPage($menu['Page']['id']);

	$options['icon'] = '';
	if (isset($options['title'])) {
		$title = '<span>' . $options['title'] . '</span>';
		$options['options']['title'] = $options['title'];
	}
	if ($hasChild) {
		$options['options']['data-toggle'] = 'dropdown';
		$options['options']['href'] = '';
		$options['url'] = '#';
		$options['options']['role'] = 'button';
		$options['options']['aria-haspopup'] = 'true';
		$options['options']['aria-expanded'] = 'false';
		$options['options']['ng-init'] = null;
		$options['options']['ng-click'] = null;
		$options['options']['class'] = 'clearfix dropdown-toggle';

		$title .= ' <span class="caret"></span>';
	} else {
		$options['options']['class'] = 'clearfix';
	}
} else {
	$hasChild = false;
	$nest--;
	$options['options']['class'] = 'clearfix menu-tree-' . $nest;

	if (isset($options['title'])) {
		$title = '<span class="pull-left">' . $options['title'] . '</span>' .
				'<span class="pull-right">' . $options['icon'] . '</span>';
	}
}


if (isset($options['title'])) {
	echo $this->NetCommonsHtml->link($title, $options['url'], $options['options']);
}

if ($hasChild) {
	echo '<ul class="dropdown-menu">';
	echo '<li class="dropdown-header">' . $options['title'] . '</li>';
	echo '<li role="separator" class="divider"></li>';
}
