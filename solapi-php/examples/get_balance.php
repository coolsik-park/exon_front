<?php
/*
 ์์ก ์กฐํ
*/
require_once("../lib/message.php");
$res = get_balance();
echo "Balance: {$res->balance}, Point: {$res->point}";
