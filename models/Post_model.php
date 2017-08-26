<?php
class Post_model extends Crud_model {

	public function __construct($params)
	{
		parent::__construct($params);

		$this->overwrite('primary_key', 'post_id');
		$this->overwrite('display', 'post_name');
		$this->overwrite('use_card', TRUE);
		$this->append('has_hash', 'post_comment', 'post');
		$this->append('action_hash', 'index', 'index');
		$this->append('action_hash', 'view', 'view');
		$this->append('action_hash', 'add', 'add');
		$this->append('action_hash', 'edit', 'edit');
		$this->append('action_hash', 'delete', 'delete');
		$this->append('select_hash', 'post_id', '`post`.`post_id`');
		$this->append('select_hash', 'post_member_id', NULL);
		$this->append('select_hash', 'member_name', NULL);
		$this->append('select_hash', 'post_name', NULL);
		$this->append('select_hash', 'post_created', NULL);
		$this->append('select_hash', 'post_text', NULL);
		$this->append('select_hash', 'count_comment', NULL);
		$this->append('hidden_list', 'post_id');
		$this->append('hidden_list', 'post_member_id');
		$this->append('set_list', 'post_name');
		$this->append('set_list', 'post_text');
		$this->append('fixed_hash', 'post_created', 'CURRENT_TIMESTAMP');
		$this->append('join_hash', 'post_member', ['table' => '`member`', 'cond' => '`member_id` = `post_member_id`']);
		$this->append('join_hash', 'post_comment', ['table' => '(SELECT `post_parent_id`, COUNT(*) AS `count_comment` FROM `post` GROUP BY `post_parent_id`)', 'cond' => '`post_comment`.`post_parent_id` = `post_id`']);
		$this->append('where_hash', 'simple', 'CONCAT(`member_name`, `post_name`, `post_text`) LIKE "%$1%"');
		$this->append('order_by_hash', 'post_id_desc', '`post_id` DESC');
		$this->append('limit_list', 10);

		// アクター:管理者
		if ($this->actor === 'a'):
			$this->remove('action_hash', 'add');
		endif;

		// アクター:会員
		if ($this->actor === 'm'):
			$this->append('fixed_hash', 'post_member_id', $this->auth['id']);
			$this->remove('action_hash', 'edit');
			$this->remove('action_hash', 'delete');
		endif;

		// アクター:ゲスト
		if ($this->actor === 'g'):
			$this->remove('action_hash', 'add');
			$this->remove('action_hash', 'edit');
			$this->remove('action_hash', 'delete');
		endif;

		// エイリアス:投稿 (post)
		if ($this->alias === 'post'):
			$this->append('where_list', '`post`.`post_parent_id` IS NULL');
		endif;

		// エイリアス:投稿 (post_comment)
		if ($this->alias === 'post_comment'):
			$this->append('select_hash', 'post_name', 'CONCAT("Re: ", `parent_name`)');
			$this->append('fixed_hash', 'post_name', '');
			$this->append('join_hash', 'post_parent', ['table' => '(SELECT `post_id`, `post_name` AS `parent_name` FROM `post`)', 'cond' => '`post_parent`.`post_id` = `post`.`post_parent_id`']);
			$this->append('where_list', "`post`.`post_parent_id` = {$this->parent_id}");
			$this->remove('where_hash', 'simple');
		endif;
	}
}
