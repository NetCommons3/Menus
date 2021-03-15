<?php
/**
 * メニュー表示
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<?php
if (!empty($treeList4Disp)) {
	echo '<nav ng-controller="MenusController">';
	echo $this->Menu->renderMain();
	echo '</nav>';
}