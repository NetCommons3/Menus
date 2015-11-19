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

<?php foreach ($menuFrameRooms as $menuFrameRoom) : ?>
	<div class="list-group">
		<?php echo $this->Menu->renderList(Hash::get($menus, $menuFrameRoom['Room']['id']), false); ?>
	</div>
<?php endforeach;
