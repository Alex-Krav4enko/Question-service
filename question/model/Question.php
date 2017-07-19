<?php

class Question
{
	private $db = null;

	function __construct($db)
	{
		$this->db = $db;
	}

  /**
   * Список вопросов без ответов
   * @return array
   */
  public function findAll()
  {
    $sth = $this->db->prepare(
      "SELECT * FROM question WHERE answer IS NULL"
    );
    if ($sth->execute()) {
      return $sth->fetchAll();
    }
    return false;
  }

  /**
   * Список вопросов одной темы
   * @return array
   */
  public function findOneThemeQuestion($id_theme)
  {
    $sth = $this->db->prepare(
      "SELECT * FROM question WHERE id_theme = :id_theme"
    );
    $sth->bindValue(':id_theme', $id_theme, PDO::PARAM_INT);
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
   * Изменение данных
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
      'UPDATE question SET `'.implode(', `', $update).' WHERE id = :id'
    );

    if (isset($params['question'])) {
      $sth->bindValue(':question', $params['question'], PDO::PARAM_STR);
    }

    if (isset($params['author'])) {
      $sth->bindValue(':author', $params['author'], PDO::PARAM_STR);
    }

    if (isset($params['answer'])) {
      $sth->bindValue(':answer', $params['answer'], PDO::PARAM_STR);
    }

    $sth->bindValue(':id', $id, PDO::PARAM_INT);

    return $sth->execute();
  }

  /**
   * Изменение темы
   * @param $id int
   * @return array
   */
  public function updateTheme($id, $id_theme)
  {
    $sth = $this->db->prepare(
      "UPDATE question SET id_theme = :id_theme WHERE id = :id"
    );
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->bindValue(':id_theme', $id_theme, PDO::PARAM_INT);
    return $sth->execute();
  }

  /**
   * Удаление вопроса
   * @param $id int
   * @return bool
   */
  function delete($id)
  {
    $sth = $this->db->prepare(
      "DELETE FROM question WHERE id = :id"
    );
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    return $sth->execute();
  }

  /**
   * Публикая вопроса
   * @param $id, $publication
   * @return bool
   */
  function publication($id, $publication)
  {
    $sth = $this->db->prepare(
      "UPDATE question SET publication = :publication WHERE id = :id"
    );
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->bindValue(':publication', $publication, PDO::PARAM_INT);
    return $sth->execute();
  }
}