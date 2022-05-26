#!/usr/bin/env php
<?php

require 'MyRedis.php';

if ($argc >= 2) {
	array_shift($argv);
	$clientName = array_shift($argv);
	$method = array_shift($argv);
	$key = array_shift($argv);
	$value = array_shift($argv);

	try {
		if ($clientName === 'redis') {
			$client = new MyRedis($method);
		} elseif ($clientName === 'memcached') {
			throw new Exception('Sorry! Memcached is not available yet!' . PHP_EOL);
		}

		if (isset($client)) {
			$result = call_user_func([$client, $method], $key, $value);

			echo $result ? "Done!\n" : "Something went wrong!\n";
		} else {
			throw new Exception('You have to run correct Redis or /*Memcached*/ script!' . PHP_EOL);
		}
	} catch (BadMethodCallException|ArgumentCountError|Exception|TypeError $exception) {
		die($exception->getMessage());
	}
} else {
	$exception = new Exception('You did not run Redis or /*Memcached*/ script!' . PHP_EOL);

	die($exception->getMessage());
}