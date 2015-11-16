<?php
/**
 * Menus index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/menus/css/style.css');
?>

<nav>
	<?php
		foreach ($menuFrameRooms as $menuFrameRoom) {
			var_dump($menuFrameRoom['Room']['id']);
			echo $this->element('Menus.Menus/' . $menuFrameSetting['MenuFrameSetting']['display_type'] . '/index', array(
				'menus' => Hash::get($menus, $menuFrameRoom['Room']['id'])
			));
		}
	?>
</nav>
