<?php
/**
 * header index template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */
?>

<ul class="breadcrumb">
	<?php
		foreach ($menuFrameRooms as $menuFrameRoom) {
			foreach (Hash::get($menus, $menuFrameRoom['Room']['id']) as $menu) {
				if ($menu['Page']['id'] == Current::read('Page.id')) {
					echo $this->Menu->renderParent($menu['Page']['room_id'], $menu['Page']['id']);
				}
			}
		}
	?>
</ul>

