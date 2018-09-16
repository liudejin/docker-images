<?php

$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('swoole-server', 9501, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
$client->send("hello world\n");
echo $client->recv();
$client->close();