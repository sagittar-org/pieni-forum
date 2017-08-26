<?php $table = $vars['model']->table; ?>
<?php if (in_array("{$table}_image", array_keys($vars['model']->select_hash))) return load_view('card_image', $vars, $vars['model']->table); ?>
<?php $alias = $vars['model']->alias; ?>
<?php $row = $vars['row']; ?>
<?php $id = $row[$vars['model']->primary_key]; ?>
    <div class="well">
      <h4 style="margin:0;">
<?php if (in_array('view', array_keys($vars['model']->action_hash))): ?>
<?php if ($row['parent_id'] !== NULL): ?>
        <a href="<?php href("{$table}/view/{$row['parent_id']}"); ?>"><span class="glyphicon glyphicon-menu-up"></span></a>
<?php endif; ?>
        <a href="<?php href("{$table}/view/{$id}"); ?>"><?php h($row[$vars['model']->display]); ?></a>
<?php else: ?>
        <?php h($row[$vars['model']->display]); ?>
<?php endif; ?>
        <spen class="text-muted">(<?php h($row['count_post']); ?>)</span>
      </h4>
      <p><?php h($row['member_name']); ?></p>
<?php if (in_array('edit', array_keys($vars['model']->action_hash)) OR in_array('delete', array_keys($vars['model']->action_hash))): ?>
      <div class="text-right" style="margin-top:-35px">
<?php foreach ($vars['model']->action_hash as $key => $row_action): ?>
<?php if (in_array($row_action, ['row', 'view'])): ?>
<?php if ($key !== 'view'): ?>
        <a href="<?php href("{$table}/{$key}/{$id}"); ?>" class="btn btn-default"><?php l("crud_{$key}"); ?></a>
<?php endif; ?>
<?php elseif ($row_action === 'edit'): ?>
        <button type="button" class="btn btn-default" data-toggle="modal" id="<?php h($alias); ?><?php h(ucfirst($key)); ?>Show<?php h($id); ?>" data-target="#<?php h($alias); ?><?php h(ucfirst($key)); ?>" onclick="<?php h($alias); ?>Pre<?php h(ucfirst($key)); ?>('<?php h($id); ?>');"><?php l("crud_{$key}"); ?></button>
<?php elseif ($row_action === 'delete'): ?>
        <button type="button" class="btn btn-default" data-toggle="modal" id="<?php h($alias); ?><?php h(ucfirst($key)); ?>Show<?php h($id); ?>" data-target="#<?php h($alias); ?><?php h(ucfirst($key)); ?>" onclick="<?php h($alias); ?>Pre<?php h(ucfirst($key)); ?>('<?php h($id); ?>');"><?php l("crud_{$key}"); ?></button>
<?php endif; ?>
<?php endforeach; ?>
      </div>
<?php endif; ?>
      <p><?php echo nl2br(h($row['post_text'], TRUE)); ?></p>
<?php
if ( ! function_exists('post_recursive'))
{
	function post_recursive($row)
	{
		static $cnt = 0;
		$key = "post_post_{$cnt}";
		load_model('post', [
			'actor'     => uri('actor'),
			'class'     => 'post',
			'alias'     => 'post_post',
			'method'    => 'index',
			'parent_id' => $row['post_id'],
			'auth'      => $_SESSION[uri('actor')]['auth'],
		], $key);
		model($key)->index();
		$cnt++;
		load_view('index', [
			'parent_row' => $row,
			'model' => model($key),
		], 'post');
	}
}
if ($alias === 'post_post' && intval($row['count_post']) > 0) post_recursive($row);
?>
    </div>
