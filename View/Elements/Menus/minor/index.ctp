<?php
/**
 * minor index template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */
?>

<?php
	echo '<div class="list-group">';
	$rootId = Current::read('Page.root_id');
	if ($rootId == 1) {
		$checkNest = 1;
	} else {
		$checkNest = 0;
	}
	foreach ($parentPages as $menu) {
		$nest = substr_count(Hash::get($pageTreeList, $menu['Page']['id']), Page::$treeParser);
		if ($nest === $checkNest) {
			$targetMenu = Hash::extract($menus, '{n}.' . $menu['Page']['id']);
			if (! empty($targetMenu)) {
				echo $this->Menu->render($targetMenu[0], false);
				echo $this->Menu->renderChild($menu['Page']['room_id'], $menu['Page']['id'], false);
			}
		}
	}
	echo '</div>';

