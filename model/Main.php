<?php

class Main
{
	private $db = null;

	function __construct($db)
	{
		$this->db = $db;
	}

  /**
   * Список вопросов
   * @return array
   */
  public function findAll()
  {
    $sth = $this->db->prepare(
      "SELECT * FROM question WHERE publication = 1"
    );
    if ($sth->execute()) {
      return $sth->fetchAll();
    }
    return false;
  }

  /**
   * Список тем
   * @return array
   */
  public function findTheme()
  {
    $sth = $this->db->prepare(
      "SELECT * FROM theme"
    );
    if ($sth->execute()) {
      return $sth->fetchAll();
    }
    return false;
  }

  /**
   * Добавление вопроса
   * @param $params array
   * @return mixed
   */

  function add($params)
  {
    $sth = $this->db->prepare(
      "INSERT INTO question (id_theme, author, email, date_added, question) VALUES (:theme, :author, :email, NOW(), :question)"
    );

    $sth->bindValue(':theme', $params['theme'], PDO::PARAM_STR);
    $sth->bindValue(':author', $params['author'], PDO::PARAM_STR);
    $sth->bindValue(':email', $params['email'], PDO::PARAM_STR);
    $sth->bindValue(':question', $params['question'], PDO::PARAM_STR);

    return $sth->execute();
  }

}