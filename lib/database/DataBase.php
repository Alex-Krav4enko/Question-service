<?php

class DataBase
{
	/**
	 * Подключение к базе данных mysql
	 * @param $host адрес
	 * @param $dbname название базы
	 * @param $user пользователь
	 * @param $pass пароль
	 */
	public static function connect($host, $dbname, $user, $pass)
	{
		try {
      $db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
      ]);
		} catch (PDOException $e) {
			die('Database error: '.$e->getMessage().'<br/>');
		}
		return $db;
	}
}

$db = DataBase::connect(
  $config['mysql']['host'],
  $config['mysql']['dbname'],
  $config['mysql']['user'],
  $config['mysql']['pass']
);