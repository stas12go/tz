<?php

use Predis\Client;

trait MyConstructor
{
	public function __construct(?string $method)
	{
		if (isset($method)) {
			if (method_exists(static::class, $method)) {
				$this->client = new Client();
			} else {
				throw new BadMethodCallException('You have to pass correct method name to use client!' . PHP_EOL . '(Hint: "add" and "delete" are correct methods!)' . PHP_EOL);
			}
		} else {
			throw new BadMethodCallException('You have to pass method name to use client!' . PHP_EOL);
		}
	}
}