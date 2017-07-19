<?php

class AdminController
{
	private $model = null;

	function __construct($db)
	{
		include 'model/Admin.php';
		$this->model = new Admin($db);
	}

  /**
   * Список администраторов
   * @return array
   */
  public function getList()
  {
    return $this->model->findAll();
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
   * Добавление администратора
   * @param $post array
   * @return mixed
   */
  function postAdd($params, $post)
  {
    $updateParam = [];
    if (isset($post['login']) && isset($post['password'])) {
      $idAdd = $this->model->add([
        'login' => $post['login'],
        'password' => $post['password']
      ]);
      if ($idAdd) {
        header('Location: /u/kravchenko/question/admin/');
      }
    }
  }

  /**
   * Изменение пароля
   * @param $id
   */

  public function postUpdate($params, $post)
  {
    if (isset($params['id']) && is_numeric($params['id'])) {
      $updateParam = [];
      if (isset($post['password'])) {
        $updateParam['password'] = $post['password'];
      }
      $isUpdate = $this->model->update($params['id'], $updateParam);

      if ($isUpdate) {
        header('Location: /u/kravchenko/question/admin/');
      }
    }
  }

  /**
   * Удаление администратора
   * @param $id
   */
  public function getDelete($params)
  {
    if (isset($params['id']) && is_numeric($params['id'])) {
      $isDelete = $this->model->delete($params['id']);
      if ($isDelete) {
        header('Location: /u/kravchenko/question/admin/');
      }
    }
  }

}