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
?>

<?php echo $this->Form->hidden('Frame.id'); ?>

<?php echo $this->Form->hidden('MenuFrameSetting.id'); ?>

<?php echo $this->Form->hidden('MenuFrameSetting.frame_key', array(
		'value' => $this->data['Frame']['key']
	)); ?>

<div class="form-group">
	<?php echo $this->Form->input('MenuFrameSetting.display_type', array(
			'type' => 'select',
			'label' => __d('menus', 'Display type'),
			'class' => 'form-control',
			'options' => MenuFrameSetting::$menuTypes
		)); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->label(null, __d('menus', 'Display page')); ?>

	<div class="pre-scrollable" style="max-height: 450px;">
		<ul class="list-group">
			<?php foreach ($this->data['Menus'] as $index => $menu) : ?>
				<li class="list-group-item">
					<?php echo $this->Form->hidden('Menus.' . $index . '.MenuFramesPage.id'); ?>
					<?php echo $this->Form->hidden('Menus.' . $index . '.MenuFramesPage.frame_key', array(
							'value' => $this->data['Frame']['key']
						)); ?>
					<?php echo $this->Form->hidden('Menus.' . $index . '.MenuFramesPage.page_id', array(
							'value' => $menu['Page']['id']
						)); ?>

					<?php echo $this->Form->checkbox('Menus.' . $index . '.MenuFramesPage.is_hidden', array(
							'div' => false,
							'value' => '0',
							'hiddenField' => '1',
							'checked' => ! (bool)$menu['MenuFramesPage']['is_hidden']
						)); ?>
					<?php echo $this->Form->label('Menus.' . $index . '.MenuFramesPage.is_hidden',
							$menu['LanguagesPage']['name']
						); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
