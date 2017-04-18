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

<nav class="menu-header navbar-default">
	<div class="clearfix">
		<button type="button" class="btn btn-default visible-xs-block pull-right navbar-toggle"
				data-toggle="collapse" data-target="#menus-<?php echo Current::read('Frame.id'); ?>" aria-expanded="false">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	<div id="menus-<?php echo Current::read('Frame.id'); ?>" class="collapse navbar-collapse">
		<div class="hidden-xs">
			<ul class="list-group nav nav-tabs nav-justified" role="tablist">
				<?php
					foreach ($menuFrameRooms as $menuFrameRoom) {
						foreach (Hash::get($menus, $menuFrameRoom['Room']['id']) as $menu) {
							$nest = substr_count(Hash::get($pageTreeList, $menu['Page']['id']), Page::$treeParser);
							if ($nest === 0) {
								echo $this->Menu->render($menu);
								echo $this->Menu->renderChild($menu['Page']['room_id'], $menu['Page']['id']);
							}
						}
					}
				?>
			</ul>
		</div>

		<div class="visible-xs-block">
			<?php echo $this->Menu->renderMain('major'); ?>
		</div>
	</div>
</nav>


