<?php
/**
 * major index template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.Menus.View.Menus.major
 */
?>

<div class="list-group" style="margin-bottom: 0px;">
	<?php
		foreach ($menus as $menu) {
			//本文の表示
			$class = 'list-group-item';
			if ($curSlug == $menu['Pages']['slug']) {
				$class .= ' active';
			}

			echo $this->element("Menus.index/link", array(
					'menu' => $menu,
					'class' => $class,
				)
			);
		}
	?>
</div>

