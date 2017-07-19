<?php

class Login
{
	private $db = null;

	function __construct($db)
	{
		$this->db = $db;
	}

  /**
   * Данные пользователя
   * @param $params array
   * @return array
   */
  public function user($login)
  {
    $sth = $this->db->prepare(
      "SELECT * FROM admin WHERE login = :login"
    );
    $sth->bindValue(':login', $login, PDO::PARAM_STR);
    if ($sth->execute()) {
      return $sth->fetch(PDO::FETCH_LAZY);
    }
    return false;
  }
}