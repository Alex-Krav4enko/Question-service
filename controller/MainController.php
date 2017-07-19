<?php

class MainController
{
	private $model = null;

	function __construct($db)
	{
		include 'model/Main.php';
		$this->model = new Main($db);
	}

  /**
   * Список вопросов и тем
   * @return array
   */
  public function getList()
  {
    $question = [];
    $question['question'] = $this->model->findAll();
    $question['theme'] = $this->model->findTheme();
    return $question;
  }

  /**
   * Добавление вопроса
   * @param $post array
   * @return mixed
   */
  function postAdd($params, $post)
  {
    $updateParam = [];
    if (isset($post['theme']) && isset($post['author']) && isset($post['email']) && isset($post['question'])) {
      $questionAdd = $this->model->add([
        'theme' => $post['theme'],
        'author' => $post['author'],
        'email' => $post['email'],
        'question' => $post['question']
      ]);
      if ($questionAdd) {
        header('Location: /u/kravchenko/question/');
      }
    }
  }

}