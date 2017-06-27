<?php
/**
 * MenuFramesRoomのデータをMenuFramesPageに登録する Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * MenuFramesRoomのデータをMenuFramesPageに登録する Migration
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\Menus\Config\Migration
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @see https://github.com/NetCommons3/NetCommons3/issues/928
 */
class MenuFramesToPageFromRoom extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'menu_frames_to_page_from_room';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'up') {
			$MenuFramesPage = $this->generateModel('MenuFramesPage');
			$tablePrefix = $MenuFramesPage->tablePrefix;

			$sql = 'INSERT INTO ' . $tablePrefix . $MenuFramesPage->table .
					'(frame_key, page_id, is_hidden, created_user, created, modified_user, modified)' .
					' SELECT' .
						' MenuFramesRoom.frame_key' .
						', Room.page_id_top' .
						', MenuFramesRoom.is_hidden' .
						', MenuFramesRoom.created_user' .
						', MenuFramesRoom.created' .
						', MenuFramesRoom.modified_user' .
						', MenuFramesRoom.modified' .
					' FROM ' . $tablePrefix . Inflector::tableize('Room') . ' Room' .
					' INNER JOIN ' . $tablePrefix . Inflector::tableize('MenuFramesRoom') . ' MenuFramesRoom' .
					' ON (MenuFramesRoom.room_id = Room.id)' .
					' LEFT JOIN ' . $tablePrefix . Inflector::tableize('MenuFramesPage') . ' MenuFramesPage' .
					' ON (' .
						'Room.page_id_top = MenuFramesPage.page_id' .
						' AND MenuFramesRoom.frame_key = MenuFramesPage.frame_key' .
					')' .
					' WHERE MenuFramesPage.id IS NULL';
			$MenuFramesPage->query($sql);
		}
		return true;
	}
}
