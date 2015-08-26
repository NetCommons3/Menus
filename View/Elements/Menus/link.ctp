<?php
/**
 * link template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

$setting = '';
if (Page::isSetting()) {
	$setting = Page::SETTING_MODE_WORD . '/';
}
?>

<a class="<?php echo $class; ?>"
   href="/<?php echo $setting . ($menu['Page']['slug'] != '' ? h($menu['Page']['slug']) . '/' : ''); ?>">
	<?php echo $menu['LanguagesPage']['name']; ?>
</a>
