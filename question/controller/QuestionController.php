<?php

class QuestionController
{
	private $model = null;

	function __construct($db)
	{
		include 'model/Question.php';
		$this->model = new Question($db);
	}

  /**
   * Список вопросов без ответов
   * @return array
   */
  public function getList()
  {
    $question = [];
    $question['question'] = $this->model->findAll();
    $question['theme'] = $this->model->findTheme();
    $question['oneThemeQuestion'] = false;
    return $question;
  }

  /**
   * Список вопросов одной темы
   * @return array
   */
  public function oneThemeQuestion($params)
  {
    if (isset($params['id_theme']) && is_numeric($params['id_theme'])) {
      $question = [];
      $question['question'] =  $this->model->findOneThemeQuestion($params['id_theme']);
      $question['theme'] = $this->model->findTheme();
      $question['oneThemeQuestion'] = true;
      return $question;
    }
  }

  /**
   * Выход
   */
  public function getLogout() {
    session_destroy();
    $this->redirect('/u/kravchenko/question/');
  }

  /**
   * Редирект
   */
  public function redirect($location) {
    header("Location: $location");
    die;
  }

  /**
   * Изменение данных
   * @param $id
   */
  public function postUpdate($params, $post)
  {
    if (isset($params['id']) && is_numeric($params['id'])) {
      $updateParam = [];
      if (isset($post['question'])) {
        $updateParam['question'] = $post['question'];
      }
      if (isset($post['author'])) {
        $updateParam['author'] = $post['author'];
      }
      if (isset($post['answer'])) {
        $updateParam['answer'] = $post['answer'];
      }
      $isUpdate = $this->model->update($params['id'], $updateParam);

      if ($isUpdate) {
        header('Location: /u/kravchenko/question/question/');
      }
    }
  }

  /**
   * Изменение темы
   * @param $id, $id_theme
   */
  public function getUpdate($params)
  {
    if (isset($params['id']) && isset($params['id_theme']) && is_numeric($params['id']) && is_numeric($params['id_theme'])) {
      $isUpdate = $this->model->updateTheme($params['id'], $params['id_theme']);

      if ($isUpdate) {
        header('Location: /u/kravchenko/question/question/');
      }
    }
  }

  /**
   * Удаление вопроса
   * @param $id
   */
  public function getDelete($params)
  {
    if (isset($params['id']) && is_numeric($params['id'])) {
      $isDelete = $this->model->delete($params['id']);
      if ($isDelete) {
        header('Location: /u/kravchenko/question/question/');
      }
    }
  }

  /**
   * Публикация вопроса
   * @param $id, $publication
   */
  public function getPublication($params)
  {
    if (isset($params['id']) && isset($params['publication']) && is_numeric($params['id']) && is_numeric($params['publication'])) {
      $isPublication = $this->model->publication($params['id'], $params['publication']);
      if ($isPublication) {
        header('Location: /u/kravchenko/question/question/');
      }
    }
  }
}