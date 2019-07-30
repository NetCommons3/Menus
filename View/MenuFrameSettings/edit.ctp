<?php
/**
 * UserAttribute edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="panel panel-default">
	<?php echo $this->NetCommonsForm->create('MenuFrameSetting'); ?>

	<div class="panel-body">
		<div class="tab-content">
			<?php echo $this->element('Menus.MenuFrameSettings/edit_form'); ?>
		</div>
	</div>

	<div class="panel-footer text-center">
		<?php echo $this->Button->cancelAndSave(__d('net_commons', 'Cancel'), __d('net_commons', 'OK')); ?>
	</div>

	<?php echo $this->Form->end(); ?>
</div>
