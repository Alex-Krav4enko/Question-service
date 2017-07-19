<?php

class Router
{
	private $dirConroller = '';
	private $db = '';
	public $urls = [];

	function __construct($dirConroller, $db)
	{
		$this->dirConroller = $dirConroller;
		$this->db = $db;
	}

	/**
	 * Добавление роутеров
	 * @param $url урл
	 * @param $controllerAndAction
	 */
	public function get($url, $controllerAndAction, $params = [])
	{
		$this->add('GET', $url, $controllerAndAction, $params);
	}

	/**
	 * Добавление роутеров
	 * @param $url урл
	 * @param $controllerAndAction
	 */
	public function post($url, $controllerAndAction, $params = [])
	{
		$this->add('POST', $url, $controllerAndAction, $params);
	}

	/**
	 * Добавление роутеров
	 * @param $url урл
	 * @param $controllerAndAction
	 */
	public function add($method, $url, $controllerAndAction, $params)
	{
		list($controller, $action) = explode('@', $controllerAndAction);

		$this->urls[$method][$url] = [
			'controller' => $controller,
			'action' => $action,
			'params' => $params
		];
	}

	/**
	 * Подключение контроллеров
	 * @param $url текущий урл
	 */
	public function run($currentUrl)
	{
		if (isset($this->urls[$_SERVER['REQUEST_METHOD']])) {
			foreach ($this->urls[$_SERVER['REQUEST_METHOD']] as $url => $urlData) {
				if (preg_match('(^'.$url.'$)', $currentUrl, $matchList)) {
					$params = [];
					foreach ($urlData['params'] as $param => $i) {
            $params[$param] = $matchList[$i];
					}
					include $this->dirConroller.$urlData['controller'].'.php';
					$controller = new $urlData['controller']($this->db);
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $controller->$urlData['action']($params, $_POST);
					} else {
						return $controller->$urlData['action']($params);
					}
        }
      }
    }
	}
}

$router = new Router('controller/', $db);
//Main
$router->get('/', 'MainController@getList');
$router->post('/add/', 'MainController@postAdd');
//Login
$router->post('/login/', 'LoginController@postLogin');
$router->get('/logout/', 'LoginController@getLogout');
//Admin
$router->get('/admin/', 'AdminController@getList');
$router->post('/admin/add/', 'AdminController@postAdd');
$router->post('/admin/update/id/(\d+)/', 'AdminController@postUpdate', ['id' => 1]);
$router->get('/admin/delete/id/(\d+)/', 'AdminController@getDelete', ['id' => 1]);
$router->get('/admin/logout/', 'AdminController@getLogout');
//Theme
$router->get('/theme/', 'ThemeController@getList');
$router->post('/theme/add/', 'ThemeController@postAdd');
$router->post('/theme/update/id/(\d+)/', 'ThemeController@postUpdate', ['id' => 1]);
$router->get('/theme/delete/id/(\d+)/', 'ThemeController@getDelete', ['id' => 1]);
$router->get('/theme/logout/', 'ThemeController@getLogout');
//Question
$router->get('/question/', 'QuestionController@getList');
$router->post('/question/update/id/(\d+)/', 'QuestionController@postUpdate', ['id' => 1]);
$router->get('/question/update/id/(\d+)/id_theme/(\d+)/', 'QuestionController@getUpdate', ['id' => 1, 'id_theme' => 2]);
$router->get('/question/publication/id/(\d+)/publication/(\d+)/', 'QuestionController@getPublication', ['id' => 1, 'publication' => 2]);
$router->get('/question/delete/id/(\d+)/', 'QuestionController@getDelete', ['id' => 1]);
$router->get('/question/id_theme/(\d+)/', 'QuestionController@oneThemeQuestion', ['id_theme' => 1]);
$router->get('/question/logout/', 'QuestionController@getLogout');

$delQuestion = str_replace('/?', '', $_SERVER['REQUEST_URI']);
$currentUrl = str_replace('u/kravchenko/question/', '', $delQuestion);

$data = $router->run($currentUrl);