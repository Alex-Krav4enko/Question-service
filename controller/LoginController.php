<?php

class LoginController
{
	private $model = null;

	function __construct($db)
	{
		include 'model/Login.php';
		$this->model = new Login($db);
	}

	public function postLogin($params, $post)
  {
    if (isset($post['signIn'])) {
      if ($this->login($post['login'], $post['password'])) {
        $this->redirect('/u/kravchenko/question/admin/');
      } else {
        $this->redirect('/u/kravchenko/question/');
      }
    }
  }

  /**
   * Выход
   */
  function getLogout() {
    session_destroy();
    $this->redirect('/u/kravchenko/question/');
  }

  /**
   * Проверка данных
   * @return array
   */
  public function login($login, $password)
  {
    $user = $this->getUser($login);
    if ($user && password_verify($password, $user['password'])) {
      session_start();
      $_SESSION['user']['id'] = $user['id'];
      $_SESSION['user']['login'] = $user['login'];
      return true;
    }
    return false;
  }

  /**
   * Данные пользователя
   * @return array
   */
  public function getUser($login)
  {
    $user = $this->model->user($login);
    if (strcmp($user['login'], $login) === 0) {
      return $user;
    }
    return null;
  }

  /**
   * Редирект
   */
  public function redirect($location) {
    header("Location: $location");
    die;
  }

}