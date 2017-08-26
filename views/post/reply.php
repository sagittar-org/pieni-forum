<?php $table = $vars['model']->table; ?>
<?php $alias = $vars['model']->alias; ?>
<?php load_model($table, ['actor' => uri('actor'), 'class' => $table, 'alias' => $alias, 'method' => $vars['key'], 'auth' => $_SESSION[uri('actor')]['auth']], "{$alias}_{$vars['key']}"); ?>
    <form class="modal fade" id="<?php h($alias); ?><?php h(ucfirst($vars['key'])); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" onsubmit="return false;">
      <input type="hidden" name="dummy" value="dummy">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php l("crud_{$vars['key']}"); ?> - <?php l($alias); ?></h4>
          </div>
          <div class="modal-body">
<?php foreach (array_unique(array_merge(array_keys(model("{$alias}_{$vars['key']}")->select_hash), model("{$alias}_{$vars['key']}")->set_list)) as $select_hash_key): ?>
<?php if (in_array($select_hash_key, model("{$alias}_{$vars['key']}")->hidden_list)) continue; ?>
<?php if (in_array($select_hash_key, ['post_name', 'post_parent_id'])): ?>
              <input type="hidden" name="<?php h($select_hash_key); ?>">
<?php else: ?>
            <div class="form-group">
<?php if (in_array($select_hash_key, model("{$alias}_{$vars['key']}")->set_list)): ?>
              <label><?php l($select_hash_key); ?></label>
              <?php load_view('input', ['key' => $select_hash_key], $table); ?>
<?php else: ?>
              <label><?php l($select_hash_key); ?></label>
              <div name="<?php h($select_hash_key); ?>"></div>
<?php endif; ?>
            </div>
<?php endif; ?>
<?php endforeach; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php l('crud_cancel'); ?></button>
            <button type="button" class="btn btn-primary ajax" onclick="<?php h($alias); ?><?php h(ucfirst($vars['key'])); ?>(this.form);"><?php l("crud_button_{$vars['key']}"); ?></button>
          </div>
        </div>
      </div>
    </form>
<?php $parent_id = $vars['model']->parent_id !== NULL ? $vars['model']->parent_id : '_'; ?>
<script>
function <?php h($alias); ?>Pre<?php h(ucfirst($vars['key'])); ?>(id)
{
	$.ajax({
		dataType: 'json',
		url: '<?php href($table); ?>/<?php h($vars['key']); ?>/' + id + '/<?php h($alias); ?>/<?php h($parent_id); ?>',
		success: function(json) {
			$('#<?php h($alias); ?><?php h(ucfirst($vars['key'])); ?>').attr('affectId', id);
<?php foreach (array_keys(model("{$alias}_{$vars['key']}")->select_hash) as $select_hash_key): ?>
<?php if (in_array($select_hash_key, model("{$alias}_{$vars['key']}")->set_list)): ?>
			$('#<?php h($alias); ?><?php h(ucfirst($vars['key'])); ?> [name=<?php h($select_hash_key); ?>]').val(json.<?php h($select_hash_key); ?>).change();
<?php else: ?>
			$('#<?php h($alias); ?><?php h(ucfirst($vars['key'])); ?> [name=<?php h($select_hash_key); ?>]').html(json.<?php h($select_hash_key); ?>);
<?php endif; ?>
<?php endforeach; ?>
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.responseText);
		},
	});
}
function <?php h($alias); ?><?php h(ucfirst($vars['key'])); ?>(form)
{
	$.ajax({
		type: 'POST',
		url: '<?php href($table); ?>/<?php h($vars['key']); ?>/' + $(form).attr('affectId') + '/<?php h($alias); ?>/<?php h($parent_id); ?>',
		data: $(form).serialize(),
		success: function() {
			$(window).scrollTop(0);
			location.href = <?php echo isset($vars['model']->success_hash[$vars['key']]) ? "'".href($vars['model']->success_hash[$vars['key']], TRUE, TRUE, TRUE)."'" : "location.href.replace(/\?.*/, '')"; ?>;
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.responseText);
		},
	});
}
</script>
