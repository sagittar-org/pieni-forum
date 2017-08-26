<?php
class Post_model extends Crud_model {

	public function __construct($params)
	{
		parent::__construct($params);

		$this->overwrite('primary_key', 'post_id');
		$this->overwrite('display', 'post_name');
		$this->overwrite('use_card', TRUE);
		$this->append('has_hash', 'post_post', 'post');
		$this->append('action_hash', 'index', 'index');
		$this->append('action_hash', 'view', 'view');
		$this->append('action_hash', 'add', 'add');
		$this->append('action_hash', 'reply', 'edit');
		$this->append('action_hash', 'edit', 'edit');
		$this->append('action_hash', 'delete', 'edit');
		$this->append('select_hash', 'post_id', '`post`.`post_id`');
		$this->append('select_hash', 'member_name', NULL);
		$this->append('select_hash', 'post_name', NULL);
		$this->append('select_hash', 'post_text', NULL);
		$this->append('select_hash', 'post_created', NULL);
		$this->append('select_hash', 'count_post', 'IFNULL(`count_post`, 0)');
		$this->append('select_hash', 'parent_id', NULL);
		$this->append('hidden_list', 'post_id');
		$this->append('hidden_list', 'parent_id');
		$this->append('set_list', 'post_name');
		$this->append('set_list', 'post_parent_id');
		$this->append('set_list', 'post_text');
		$this->append('join_hash', 'member', ['table' => 'member', 'cond' => '`member_id` = `post_member_id`']);
		$this->append('join_hash', 'count', ['table' => '(SELECT `post_parent_id` AS `count_id`, COUNT(*) AS `count_post` FROM `post` GROUP BY `post_parent_id`)', 'cond' => '`count_id` = `post_id`']);
		$this->append('join_hash', 'parent', ['table' => '(SELECT `post_parent_id` AS `parent_id` FROM `post` WHERE `post_parent_id` IS NOT NULL)', 'cond' => '`parent_id` = `post_id`']);
		$this->append('order_by_hash', 'post_id_desc', '`post_id` DESC');
		$this->append('limit_list', 10);

		// アクター:管理者
		if ($this->actor === 'a'):
			$this->remove('action_hash', 'add');
		endif;

		// アクター:会員
		if ($this->actor === 'm'):
			$this->append('fixed_hash', 'post_member_id', $this->auth['id']);
			$this->append('fixed_hash', 'post_created', 'CURRENT_TIMESTAMP');
			$this->remove('action_hash', 'delete');
		endif;

		// アクター:ゲスト
		if ($this->actor === 'g'):
			$this->remove('action_hash', 'add');
			$this->remove('action_hash', 'edit');
			$this->remove('action_hash', 'delete');
		endif;

		// アクション:reply
		if ($this->action === 'reply'):
			$this->append('select_hash', 'post_name', 'CONCAT("Re:", `post_name`)');
			$this->append('select_hash', 'post_text', '""');
			$this->append('select_hash', 'post_parent_id', '`post_id`');
		endif;

		// アクション:add
		if ($this->action === 'add'):
			$this->remove('select_hash', 'count_post');
			$this->remove('set_list', 'post_parent_id');
		endif;

		// アクション:edit
		if ($this->action === 'edit'):
			$this->remove('select_hash', 'count_post');
			$this->remove('set_list', 'post_parent_id');
		endif;

		// エイリアス:post_post (post_post)
		if ($this->alias === 'post_post'):
			$this->remove('action_hash', 'add');

			// アクション:index
			if ($this->action === 'index'):
				$this->append('where_list', "`post_parent_id` = {$this->parent_id}");
			endif;
		endif;
	}
}
