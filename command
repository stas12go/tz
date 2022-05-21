#!/usr/bin/env php
<?php

require 'MyRedis.php';

if ($argc >= 2) {
	array_shift($argv);
	$clientName = array_shift($argv);
	$method = array_shift($argv);
	$params = $argv;

	try {
		if ($clientName === 'redis') {
			$client = new MyRedis($method, $params);
		} elseif ($clientName === 'memcached') {
//			$client = new MyMemcached();
			throw new Exception('Sorry! Memcached is not available yet!' . PHP_EOL);
		}

		if (isset($client)) {
			$result = call_user_func([$client, $method], $params);

			echo $result . PHP_EOL;
		} else {
			throw new Exception('You have to run correct Redis or /* Memcached */ script!' . PHP_EOL);
		}
	} catch (BadMethodCallException | ArgumentCountError | Exception $exception) {
		die($exception->getMessage());
	}
} else {
	$exception = new Exception('You did not run Redis or Memcached script!' . PHP_EOL);

	die($exception->getMessage());
}