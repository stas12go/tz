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
	 * Time to live
	 */
	private const TTL = 3600;

	/**
	 * @inheritDoc
	 */
	public function add(...$params): bool
	{
		list($key, $value) = $params;

		if (empty($key) || empty($value)) {
			throw new ArgumentCountError("You have to pass {key} {value} to execute \"redis add\" method!\n");
		}

		$hasKeyBeenSaved = $this->client->set($key, $value);

		if ($hasKeyBeenSaved == 'OK') {
			$this->client->expire($key, self::TTL);

			return true;
		} else {
			throw new Exception("Oops! Something went wrong!\n");
		}
	}

	/**
	 * @inheritDoc
	 */
	public function delete(?string $key): bool
	{
		if (!isset($key)) {
			throw new TypeError("You have to pass {key} to execute \"redis delete\" method!\n");
		}

		$countOfDeletedEntries = $this->client->del($key);
		$result = is_numeric($countOfDeletedEntries);

		return $result;
	}

	/**
	 * @inheritDoc
	 */
	public function getAll(string $pattern = '*'): array
	{
		$keys = $this->client->keys($pattern);
		$values = $this->client->mget($keys);
		$result = array_combine($keys, $values);

		return $result;
	}
}