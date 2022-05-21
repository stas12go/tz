<?php

use Predis\Client;

require 'vendor/predis/predis/autoload.php';
require 'MyConstructor.php';
require 'MyCache.php';

class MyRedis implements MyCache
{
	use MyConstructor;
	/**
	 * @var Client
	 */
	public $client;

	/**
	 * @inheritDoc
	 * @throws Exception
	 */
	public function add(array $params, $ttl = 3600): string
	{
		if (count($params) === 2) {
			list($key, $value) = $params;
		} else {
			throw new ArgumentCountError('You have to pass {key} {value} to execute "redis add" method!' . PHP_EOL);
		}

		$result = $this->client->set($key, $value);

		if ($result == 'OK') {
			$this->client->expire($key, $ttl);
		} else {
			throw new Exception('Oops! Something went wrong!');
		}

		return $result;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(array $params): string
	{
		if (count($params) === 1) {
			$key = $params[0];
		} else {
			throw new ArgumentCountError('You have to pass {key} to execute "redis delete" method!' . PHP_EOL);
		}

		$countOfDeletedEntries = $this->client->del($key);
		$result = 'Count of deleted entries: ' . $countOfDeletedEntries . '.';

		return $result;
	}
}