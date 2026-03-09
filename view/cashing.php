<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379); // replace with your Redis server IP
$redis->set('test', 'Hello Redis');
echo $redis->get('test');
?>
