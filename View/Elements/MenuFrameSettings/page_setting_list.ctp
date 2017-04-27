<?php
/**
 * ページ設定(表示・非表示、クリック時の表示)
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<li class="list-group-item menu-list-item">
	<div class="clearfix">
		<div class="pull-left checkbox checkbox-inline">
			<?php
				echo $this->NetCommonsForm->hidden($prefixInput . '.id');
				echo $this->NetCommonsForm->hidden($prefixInput . '.frame_key', array(
					'value' => $this->request->data['Frame']['key']
				));
				echo $this->NetCommonsForm->hidden($prefixInput . '.page_id', array('value' => $pageId));
			?>
			<label class="control-label menu-is-hidden-checkbox" for="<?php echo $this->NetCommonsForm->domId($prefixInput . '.is_hidden'); ?>">
				<?php
					echo str_repeat('<span class="menu-edit-tree"> </span>', $nest);

					echo '<span class="' . $pageNameCss . '">';
					echo $this->NetCommonsForm->checkbox($prefixInput . '.is_hidden', array(
						'div' => false,
						'value' => '0',
						'hiddenField' => '1',
						'checked' => ! (bool)Hash::get($this->request->data, $prefixInput . '.is_hidden') || $roomDisabled,
						'ng-click' => 'checkChildPages($event, ' . json_encode($domChildPageIds) . ')',
						'ng-disabled' => $roomDisabled
					));
					echo h(Hash::get($menu, 'PagesLanguage.name'));
					echo '</span>';
				?>
			</label>
		</div>
		<div class="pull-right">
			<?php
				if (! Hash::get($menu, 'MenuFramesPage.folder_type')) {
					$title = __d('menus', 'Show the page of clicked on');
				} else {
					$title = __d('menus', 'Show lower layer page clicked');
				}
			?>
			<?php if ($displayWhenClicking) : ?>
				<div class="btn-group">
					<button type="button" data-toggle="dropdown"
							class="btn btn-default btn-xs dropdown-toggle" title="<?php echo $title; ?>">
						<?php echo __d('menus', 'Display when clicking'); ?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li>
							<?php
								echo $this->NetCommonsForm->radio($prefixInput . '.folder_type',
									array('0' => __d('menus', 'Show the page of clicked on')),
									array(
										'error' => false,
										'hiddenField' => false,
										'checked' => !Hash::get($menu, 'MenuFramesPage.folder_type'),
									)
								);
							?>
						</li>
						<li>
							<?php
								echo $this->NetCommonsForm->radio($prefixInput . '.folder_type',
									array('1' => __d('menus', 'Show lower layer page clicked')),
									array(
										'error' => false,
										'hiddenField' => false,
										'checked' => Hash::get($menu, 'MenuFramesPage.folder_type'),
									)
								);
							?>
						</li>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</li>
