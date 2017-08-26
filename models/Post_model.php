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
		$this->append('action_hash', 'edit', 'edit');
		$this->append('action_hash', 'delete', 'delete');
		$this->append('select_hash', 'post_id', '`post`.`post_id`');
		$this->append('select_hash', 'post_name', NULL);
		$this->append('hidden_list', 'post_id');
		$this->append('set_list', 'post_name');
		$this->append('order_by_hash', 'post_id_desc', '`post_id` DESC');
		$this->append('limit_list', 10);

		// エイリアス:投稿 (post)
		if ($this->alias === 'post'):
			$this->append('where_list', "`post_parent_id` IS NULL");
		endif;

		// エイリアス:post_post (post_post)
		if ($this->alias === 'post_post'):
			$this->append('fixed_hash', 'post_parent_id', $this->parent_id);
			$this->append('where_list', "`post_parent_id` = '{$this->parent_id}'");
		endif;
	}
}
