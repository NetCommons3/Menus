<?php
/**
 * UserAttribute edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$MenuFrameSetting = ClassRegistry::init('Menus.MenuFrameSetting');
?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('MenuFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('MenuFrameSetting.frame_key'); ?>

<div class="form-group">
	<?php echo $this->NetCommonsForm->input('MenuFrameSetting.display_type', array(
			'type' => 'select',
			'label' => __d('menus', 'Display type'),
			'class' => 'form-control',
			'options' => $MenuFrameSetting->menuTypes
		)); ?>
</div>

<div class="form-group" ng-controller="MenuFrameSettingsController">
	<?php echo $this->NetCommonsForm->label(null, __d('menus', 'Display page')); ?>

	<?php
		$first = true;

		foreach ($pageTreeList as $treePageId) {
			$pageId = trim($treePageId);
			$page = Hash::get($pages, $pageId);

			$roomId = $page['Room']['id'];
			$room = Hash::get($rooms, $roomId);

			$menu = Hash::get($this->data['Menus'], $roomId . '.' . $pageId);

			$nest = $this->Menu->getIndent($treePageId);
			if ($nest === 0 && substr_count($treePageId, Page::$treeParser) === 0) {
				if (! $first) {
					echo '</div>';
				}
				echo '<div class="panel panel-default">';

				echo '<div class="panel-heading menu-list-item">';

				echo $this->MenuForm->checkboxMenuFramesRoom($roomId, $room, $pageId);
				echo '</div>';

				echo '<ul class="list-group">';
				$first = false;

				$rootRoomId = $roomId;
				$rootRoom = $room;
			} else {
				echo $this->MenuForm->checkboxMenuFramesPage(
					$roomId, $room, $pageId, $menu, $rootRoomId, $rootRoom
				);
			}
		}

		echo '</ul>';
		echo '</div>';
	?>
</div>
