<?php
/**
 * パンくずタイプのメニュー
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

if (isset($options['title'])) {
	$title = $options['title'];
	if ($isActive) {
		echo '<li class="active">' . $title . '</li>';
	} else {
		echo '<li>' . $this->NetCommonsHtml->link($title, $options['url'], $options['options']) . '</li>';
	}
}
