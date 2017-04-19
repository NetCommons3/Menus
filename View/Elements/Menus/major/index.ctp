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

//var_dump($menuFrameRooms);
//var_dump($pageTreeList);
?>

<?php
	foreach ($pageTreeList as $treePageId) {
		$nest = substr_count($treePageId, Page::$treeParser);
		$pageId = trim($treePageId);
		$page = Hash::get($pages, $pageId);



	}
?>

<?php foreach ($menuFrameRooms as $menuFrameRoom) : ?>
	<?php
		echo '<div class="list-group">';
		foreach (Hash::get($menus, $menuFrameRoom['Room']['id']) as $i => $menu) {
//			var_dump(Hash::get($pageTreeList, $menu['Page']['id']));
			$nest = substr_count(Hash::get($pageTreeList, $menu['Page']['id']), Page::$treeParser);
//			var_dump($menu);
			if ($nest === 0) {
				echo $this->Menu->render($menu);
				echo $this->Menu->renderChild($menu['Page']['room_id'], $menu['Page']['id']);
			}
		}
		echo '</div>';
	?>
<?php endforeach;
