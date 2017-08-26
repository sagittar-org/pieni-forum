<?php
$config['uri']['actor_hash'] = [
	'g' => 'guest',
	'm' => 'member',
	'a' => 'admin',
];
$config['uri']['table_list'] = [
	'post',
	'member',
	'admin',
	'directive',
];
$config['uri']['action_hash'] = [
	'proxy'  => 'row',
	'index'  => 'index',
	'view'   => 'view',
	'add'    => 'add',
	'reply'  => 'edit',
	'edit'   => 'edit',
	'delete' => 'delete',
];
$config['uri']['alias_list'] = [
	'post_post',
];
$config['auth'] = [
	'm' => [
		'join'  => 'INSERT INTO `member` (`member_name`, `member_email`, `member_password`) values ("$name", "$email", "$password")',
		'login' => 'SELECT `member_id` AS `id`, `member_name` AS `name`, `member_email` AS `email`, `member_password` AS `password` FROM `member` WHERE `member_email` = "$1"',
		'proxy' => 'SELECT `member_id` AS `id`, `member_name` AS `name`, `member_email` AS `email` FROM `member` WHERE `member_id` = "$1"',
	],
	'a' => [
		'login' => 'SELECT `admin_id` AS `id`, `admin_name` AS `name`, `admin_email` AS `email`, `admin_password` AS `password` FROM `admin` WHERE `admin_email` = "$1"',
	],
];
$config['db'] = [
	'debug'    => FALSE,
	'host'     => 'localhost',
	'username' => 'root',
	'passwd'   => '',
	'dbname'   => 'pieni-forum',
];
$config['mail'] = [
	'from'     => 'noreply@localhost',
	'admin'    => 'root@localhost',
];
$config['session'] = [
	'name'     => 'pieni-forum',
];
$config['password'] = [
	'hash'     => TRUE,
];
