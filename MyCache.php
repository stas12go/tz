<?php

interface MyCache
{
	/**
	 * Метод используется для добавления новых записей в Redis.
	 *
	 * @param ...$params
	 * @return bool
	 */
	public function add(...$params): bool;

	/**
	 * Метод предназначен для удаления записи из Redis по её ключу.
	 *
	 * @param string $key
	 * @return bool Вернёт сообщение о количестве удалённых записей (0 или 1).
	 */
	public function delete(string $key): bool;

	/**
	 * Метод предназначен для получения ассоциативного массива, содержащего ключи-значения записей, хранящихся в Redis.
	 *
	 * @return array|false
	 */
	public function getAll();
}