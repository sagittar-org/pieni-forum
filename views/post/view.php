<?php $table = $vars['model']->table; ?>
<?php $alias = $vars['model']->alias; ?>
<?php $row = $vars['model']->row; ?>
<?php $id = $row[$vars['model']->primary_key]; ?>
    <div class="container">
      <h1>
<?php r($row); ?>
<?php if ($row['parent_id'] !== NULL): ?>
        <a href="<?php href("{$table}/view/{$row['parent_id']}"); ?>"><span class="glyphicon glyphicon-menu-up"></span></a>
<?php endif; ?>
        <?php h($row[$vars['model']->display]); ?>
        <spen class="text-muted">(<?php h($row['count_post']); ?>)</span>
      </h1>
      <p>
        <?php h($row['member_name']); ?><br>
        <span class="text-muted"><?php h(date('Y-m-d H:i', strtotime($row['post_created']))); ?></span><br>
      </p>
<?php if (in_array('edit', array_keys($vars['model']->action_hash)) OR in_array('delete', array_keys($vars['model']->action_hash))): ?>
      <div class="text-right" style="margin-top:-46px">
<?php foreach ($vars['model']->action_hash as $key => $row_action): ?>
<?php if ($key === 'view') continue; ?>
<?php if ($row_action !== 'view') continue; ?>
            <a href="<?php href("{$table}/{$key}/{$id}"); ?>" class="btn btn-default"><?php l("crud_{$key}"); ?></a>
<?php endforeach; ?>
<?php foreach ($vars['model']->action_hash as $key => $row_action): ?>
<?php if ($row_action !== 'edit') continue; ?>
            <button type="button" class="btn btn-default" data-toggle="modal" id="<?php h($alias); ?><?php h(ucfirst($key)); ?>Show<?php h($id); ?>" data-target="#<?php h($alias); ?><?php h(ucfirst($key)); ?>" onclick="<?php h($alias); ?>Pre<?php h(ucfirst($key)); ?>('<?php h($id); ?>');"><?php l("crud_{$key}"); ?></button>
<?php endforeach; ?>
<?php foreach ($vars['model']->action_hash as $key => $row_action): ?>
<?php if ($row_action !== 'delete') continue; ?>
            <button type="button" class="btn btn-default" data-toggle="modal" id="<?php h($alias); ?><?php h(ucfirst($key)); ?>Show<?php h($id); ?>" data-target="#<?php h($alias); ?><?php h(ucfirst($key)); ?>" onclick="<?php h($alias); ?>Pre<?php h(ucfirst($key)); ?>('<?php h($id); ?>');"><?php l("crud_{$key}"); ?></button>
<?php endforeach; ?>
      </div>
<?php endif; ?>
      <hr>
      <p class="lead"><?php echo nl2br(h($row['post_text'], TRUE)); ?></p>
    </div>
<?php load_view('row_action', $vars, $table); ?>
<?php foreach ($vars['model']->has_hash as $key => $has): ?>
<?php if ( ! in_array('index', array_keys($vars['model']->action_hash))) continue; ?>
<?php load_view('index', $has, $has['model']->table); ?>
<?php endforeach; ?>
<?php /* ?>
    <div class="container">
      <button type="button" class="btn btn-default" onclick="history.back();" style="width:100%;"><?php l('crud_back'); ?></button>
    </div>
<?php */ ?>
