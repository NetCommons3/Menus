<?php
/**
 * タブ(nav-tabs)表示タイプのメニュー
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
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
			<ul class="list-group nav nav-tabs nav-justified menu-header-tabs" role="tablist">
				<?php
					$first = true;
					foreach ($pageTreeList2 as $treePageId) {
						if (! $this->Menu2->displayPage($treePageId)) {
							continue;
						}

						$pageId = trim($treePageId);
						$page = Hash::get($pages, $pageId);
						$menu = Hash::get($menus, $page['Room']['id'] . '.' . $pageId);

						$nest = $this->Menu2->getIndent($treePageId);
						if ($nest === 0) {
							if (! $first) {
								echo $this->element('Menus.Menus/header/list_end', [
									'nest' => $nest,
									'hasChild' => $hasChild,
								]);
							}
							$first = false;
							$hasChild = $this->Menu2->hasChildPage($pageId);
						} else {
							echo $this->element('Menus.Menus/header/list_end', [
								'nest' => $nest,
								'hasChild' => false,
							]);
						}

						echo $this->element('Menus.Menus/header/list_start', [
							'pageId' => $pageId,
							'nest' => $nest,
							'isActive' => $this->Menu2->isActive($page),
							'hasChild' => $hasChild,
						]);

						echo $this->Menu2->renderPage($treePageId);
					}

					echo $this->element('Menus.Menus/header/list_end', [
						'nest' => 0,
						'hasChild' => $hasChild,
					]);
				?>
			</ul>
		</div>

		<div class="visible-xs-block">
			<?php echo $this->Menu->renderMain('major'); ?>
		</div>
	</div>
</nav>


