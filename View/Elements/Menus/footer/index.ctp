<?php
/**
 * 丸み(nav-pills)表示タイプのメニュー
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="list-group nav nav-pills nav-justified menu-footer-tabs">
	<?php
		$first = true;
		foreach ($pageTreeList as $treePageId) {
			if (! $this->Menu->displayPage($treePageId)) {
				continue;
			}

			$pageId = trim($treePageId);
			$page = Hash::get($pages, $pageId);
			$menu = Hash::get($menus, $page['Room']['id'] . '.' . $pageId);

			$nest = $this->Menu->getIndent($treePageId);
			if ($nest === 0) {
				if (! $first) {
					echo $this->element('Menus.Menus/footer/list_end', [
						'nest' => $nest,
						'hasChild' => $hasChild,
					]);
				}
				$first = false;
				$hasChild = $this->Menu->hasChildPage($pageId);
			} else {
				echo $this->element('Menus.Menus/footer/list_end', [
					'nest' => $nest,
					'hasChild' => false,
				]);
			}

			echo $this->element('Menus.Menus/footer/list_start', [
				'pageId' => $pageId,
				'nest' => $nest,
				'isActive' => $this->Menu->isActive($page),
				'hasChild' => $hasChild,
			]);

			echo $this->Menu->renderPage($treePageId);
		}

		echo $this->element('Menus.Menus/footer/list_end', [
			'nest' => 0,
			'hasChild' => $hasChild,
		]);
	?>
</ul>
