<?php
/**
 * Menus index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<nav>
	<?php echo $this->element('Menus.Menus/' . $menuFrameSetting['MenuFrameSetting']['display_type'] . '/index', array(
		'curSlug' => PageLayoutHelper::$page['permalink']
		)); ?>
</nav>
