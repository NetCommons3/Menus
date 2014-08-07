<?php
/**
 * link template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.Menus.View.Menus.index
 */

$setting = '';
if (Configure::read('Pages.isSetting')) {
	$setting = Configure::read('Pages.settingModeWord') . '/';
}
?>

<a class="<?php echo $class; ?>"
   href="/<?php echo $setting . ($menu['Pages']['slug'] != '' ? h($menu['Pages']['slug']) . '/' : ''); ?>">
	<?php echo $menu['MenuPage']['name']; ?>
</a>
