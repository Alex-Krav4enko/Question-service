<?php

class Admin
{
	private $db = null;

	function __construct($db)
	{
		$this->db = $db;
	}

  /**
   * Список администраторов
   * @return array
   */
  public function findAll()
  {
    $sth = $this->db->prepare(
      "SELECT id, login, password FROM admin"
    );
    if ($sth->execute()) {
      return $sth->fetchAll();
    }
    return false;
  }

  /**
   * Добавление администратора
   * @param $params array
   * @return mixed
   */

  function add($params)
  {
    $sth = $this->db->prepare(
      "INSERT INTO admin(login, password) VALUES(:login, :password)"
    );

    $sth->bindValue(':login', $params['login'], PDO::PARAM_STR);
    $sth->bindValue(':password', password_hash($params['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);

    return $sth->execute();
  }

  /**
   * Изменение пароля
   * @param $id int
   * @param $params array
   * @return mixed
   */
  function update($id, $params)
  {
    if (count($params) == 0) {
      return false;
    }
    $update = [];
    foreach ($params as $param => $value) {
      $update[] = $param.'`=:'.$param;
    }
    $sth = $this->db->prepare(
      'UPDATE admin SET `'.implode(', `', $update).' WHERE id = :id'
    );

    if (isset($params['password'])) {
      $sth->bindValue(':password', password_hash($params['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
    }

    $sth->bindValue(':id', $id, PDO::PARAM_INT);

    return $sth->execute();
  }

  /**
   * Удаление администратора
   * @param $id int
   * @return mixed
   */
  function delete($id)
  {
    $sth = $this->db->prepare(
      "DELETE FROM admin WHERE id = :id"
    );
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    return $sth->execute();
  }

}