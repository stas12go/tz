<?php

require '../MyRedis.php';

$uriParts = explode('/', $_SERVER['REQUEST_URI']);

$clientName = 'redis';
$param = $uriParts[3];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$method = 'getAll';
	$param .= '*';
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
	$method = 'delete';
}

//if (isset($method) && isset($param)) {
	try {
		$client = new MyRedis($method);

		$methodResult = call_user_func([$client, $method], $param);

		$result = ['status' => true, 'code' => 200, 'data' => []];

		if (is_array($methodResult)) {
			$result['data'] = $methodResult;
		}
	} catch (BadMethodCallException|ArgumentCountError|Exception $exception) {
		$result = ['status' => false, 'code' => 500, 'data' => ['message' => $exception->getMessage()]];
	} finally {
		echo json_encode($result);
	}
//}