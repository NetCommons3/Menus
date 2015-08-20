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

<ul class="list-group nav nav-tabs" role="tablist" style="margin-bottom: 0px;">
	<?php
		foreach ($menus as $menu) {
			if ($menu['MenuFramesPage']['is_hidden']) {
				continue;
			}

			//本文の表示
			$class = '';
			if ($curSlug == $menu['Page']['slug']) {
				$class = 'active';
			}
			echo '<li class="' . $class . '">';

			echo $this->element('Menus/link', array(
					'menu' => $menu,
					'class' => $class,
				)
			);

			echo '</li>';
		}
	?>
</ul>

