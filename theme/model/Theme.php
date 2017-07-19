<?php

class Theme
{
	private $db = null;

	function __construct($db)
	{
		$this->db = $db;
	}

  /**
   * Список тем
   * @return array
   */
  public function findAll()
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
   * Список вопросов
   * @return array
   */
  public function findQuestion()
  {
    $sth = $this->db->prepare(
      "SELECT * FROM question"
    );
    if ($sth->execute()) {
      return $sth->fetchAll();
    }
    return false;
  }

  /**
   * Добавление темы
   * @param $params array
   * @return mixed
   */
  function add($params)
  {
    $sth = $this->db->prepare(
      "INSERT INTO theme (title) VALUES (:title)"
    );

    $sth->bindValue(':title', $params['title'], PDO::PARAM_STR);

    return $sth->execute();
  }

  /**
   * Изменение названия темы
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
      'UPDATE theme SET `'.implode(', `', $update).' WHERE id = :id'
    );

    if (isset($params['title'])) {
      $sth->bindValue(':title', $params['title'], PDO::PARAM_STR);
    }

    $sth->bindValue(':id', $id, PDO::PARAM_INT);

    return $sth->execute();
  }

  /**
   * Удаление темы
   * @param $id int
   * @return mixed
   */
  function delete($id)
  {
    $sth = $this->db->prepare(
      "DELETE FROM theme WHERE id = :id"
    );
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    return $sth->execute();
  }

  /**
   * Удаление вопросов темы
   * @param $id int
   * @return mixed
   */
  function deleteQuestion($id)
  {
    $sth = $this->db->prepare(
      "DELETE FROM question WHERE id_theme = :id"
    );
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    return $sth->execute();
  }
}
