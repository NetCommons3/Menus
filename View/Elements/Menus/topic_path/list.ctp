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

$class = '';
//$class .= 'list-group-item clearfix';
//$class .= ' menu-tree-' . $nest;
if ($isActive) {
	$class .= ' active';
}
$options['options']['class'] = $class;

if (isset($options['title'])) {
	$title = $options['title'];
			//'<span class="pull-right">' . $options['icon'] . '</span>';

	echo '<li>' . $this->NetCommonsHtml->link($title, $options['url'], $options['options']) . '</li>';
}
