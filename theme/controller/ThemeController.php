<?php

class ThemeController
{
	private $model = null;

	function __construct($db)
	{
		include 'model/Theme.php';
		$this->model = new Theme($db);
	}

  /**
   * Список тем
   * @return array
   */
  public function getList()
  {
    $data = [];
    $data['theme'] = $this->model->findAll();
    $data['question'] = $this->model->findQuestion();
    foreach ($data['theme'] as $index => $theme) {
      $count = [];
      $count_publication = [];
      $count_no_answer = [];
      foreach ($data['question'] as $question) {
        if ($question['id_theme'] == $theme['id']) {
          $count[] = $question;
        }
        if ($question['id_theme'] == $theme['id'] && $question['publication'] == 1) {
          $count_publication[] = $question;
        }
        if ($question['id_theme'] == $theme['id'] && $question['answer'] == false) {
          $count_no_answer[] = $question;
        }
      }
      $data['theme'][$index]['count'] = count($count);
      $data['theme'][$index]['count_publication'] = count($count_publication);
      $data['theme'][$index]['count_no_answer'] = count($count_no_answer);
    }
    return $data;
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
   * Добавление темы
   * @param $post array
   * @return mixed
   */
  function postAdd($params, $post)
  {
    $updateParam = [];
    if (isset($post['title'])) {
      $idAdd = $this->model->add([
        'title' => $post['title']
      ]);
      if ($idAdd) {
        header('Location: /u/kravchenko/question/theme/');
      }
    }
  }

  /**
   * Изменение названия темы
   * @param $id
   */

  public function postUpdate($params, $post)
  {
    if (isset($params['id']) && is_numeric($params['id'])) {
      $updateParam = [];
      if (isset($post['title'])) {
        $updateParam['title'] = $post['title'];
      }
      $isUpdate = $this->model->update($params['id'], $updateParam);

      if ($isUpdate) {
        header('Location: /u/kravchenko/question/theme/');
      }
    }
  }

  /**
   * Удаление темы и вопросов
   * @param $id
   */
  public function getDelete($params)
  {
    if (isset($params['id']) && is_numeric($params['id'])) {
      $isDeleteTheme = $this->model->delete($params['id']);
      $isDeleteQuestion = $this->model->deleteQuestion($params['id']);
      if ($isDeleteTheme && $isDeleteQuestion) {
        header('Location: /u/kravchenko/question/theme/');
      }
    }
  }

}