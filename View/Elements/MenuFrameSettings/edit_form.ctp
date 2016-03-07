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

<div class="form-group">
	<?php echo $this->NetCommonsForm->label(null, __d('menus', 'Display page')); ?>

	<?php foreach ($rooms as $roomId => $room) : ?>
		<div class="panel panel-default">
			<div class="panel-heading menu-list-item">
				<?php echo $this->Menu->checkboxMenuFramesRoom($roomId, $room); ?>
			</div>

			<?php if (Hash::get($this->data, 'Menus.' . $roomId)) : ?>
				<ul class="list-group">
					<?php foreach ($this->data['Menus'][$roomId] as $pageId => $menu) : ?>
						<?php echo $this->Menu->checkboxMenuFramesPage($roomId, $room, $pageId, $menu); ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
