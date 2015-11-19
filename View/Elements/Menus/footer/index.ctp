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

<ul class="list-group nav nav-pills">
	<?php
		foreach ($menuFrameRooms as $menuFrameRoom) {
			echo $this->Menu->renderList(Hash::get($menus, $menuFrameRoom['Room']['id']), true);
		}
	?>
</ul>
