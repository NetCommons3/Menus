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

if ($isActive) {
	$listTagStart = '<li class="active">';
} else {
	$listTagStart = '<li>';
}
$listTagEnd = '</li>';

$class = '';
$class .= 'list-group-item';
$class .= ' menu-tree-' . $nest;
$options['options']['class'] = $class;

if (isset($options['title'])) {
	$title = $options['icon'] . $options['title'];

	echo $listTagStart;
	echo $this->NetCommonsHtml->link($title, $options['url'], $options['options']);
	echo $listTagEnd;
}
