<?php
/**
 * major index template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */
?>

<div class="list-group menu-major-list">
	<?php
		foreach ($menus as $menu) {
			if ($menu['MenuFramesPage']['is_hidden']) {
				continue;
			}

			//本文の表示
			$class = 'list-group-item';
			if (Current::read('Page.permalink') === (string)$menu['Page']['slug']) {
				$class .= ' active';
			}

			echo $this->element('Menus/link', array(
					'menu' => $menu,
					'class' => $class,
				)
			);
		}
	?>
</div>

