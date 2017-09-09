<?php
$config['uri']['class_list'] = [
	'welcome',
	'inquiry',
	'auth',
	'spec',
	'docs',
	'forum',
];
$config['uri']['table_list'] = [
	'post',
	'member',
	'admin',
	'directive',
];
$config['uri']['action_hash'] = [
	'index'    => 'index',
	'proxy'    => 'row',
	'view'     => 'view',
	'reply'    => 'edit',
	'add'      => 'add',
	'edit'     => 'edit',
	'delete'   => 'delete',
];
$config['uri']['alias_list'] = [
	'post_post',
];

$config['db']['dbname'] = 'pieni-forum';

$config['session']['name'] = 'pieni-forum';
