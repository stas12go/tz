<?php

interface MyCache
{
	/**
	 * Метод используется для добавления новых записей в Redis.
	 *
	 * @param array $params Массив, содержащий ключ и значение новой записи.
	 * @param int $ttl Время жизни записи.
	 * @return string Вернёт 'OK', если сохранение записи прошло успешно. В противном случае
	 */
	public function add(array $params, int $ttl): string;

	/**
	 * Метод предназначен для удаления записи из Redis по её ключу.
	 *
	 * @param array $params Массив, содержащий ключ удаляемой записи.
	 * @return string Вернёт сообщение о количестве удалённых записей (0 или 1).
	 */
	public function delete(array $params): string;
}