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

<ul class="list-group nav nav-tabs" role="tablist">
	<?php
		foreach ($menuFrameRooms as $menuFrameRoom) {
			foreach (Hash::get($menus, $menuFrameRoom['Room']['id']) as $menu) {
				$nest = substr_count(Hash::get($pageTreeList, $menu['Page']['id']), Page::$treeParser);
				if ($nest === 0) {
					echo $this->Menu->render($menu, true);
					echo $this->Menu->renderChild($menu['Page']['room_id'], $menu['Page']['id'], true);
				}
			}
		}
	?>
</ul>

