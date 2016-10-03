<?php
class ApplicationController
{
  private $vars = array();

  var $layout    = 'application',
      $rendering = true,
      $notice    = null,
      $actionName,
      $controllerName,
      $params,
      $data;

  function __construct($controllerName, $actionName)
  {
    $this->controllerName = $controllerName;
    $this->actionName     = $actionName;
    $this->format         = $this->getRequestFormat();
  }

  function __destruct()
  {
    if ( $this->rendering && $this->format == "text/html" )
      $this->render();
    else if ( $this->format == "application/json" )
      echo json_encode( $this->vars['json'] );
  }

  function addVar($name, $var)
  {
    $this->vars = array_merge($this->vars, array($name => $var));
  }

  /*
   * Render view through layout
   */
  function render()
  {
    extract( $this->vars );

    $title = isset($title) ? $title : 'Marmiton';

    ob_start();
    require_once ROOT_PATH.'/views/'.$this->controllerName.'/'.$this->actionName.'.php';
    $content = ob_get_clean();

    require_once ROOT_PATH.'/views/layouts/'.$this->layout.'.php';
  }

  function renderPartial($file)
  {
    ob_start();
    require_once ROOT_PATH.'/views/'.$file.'.php';
    $content = ob_get_clean();
    return $content;
  }

  /*
   * Notices
   */
  function setNotice($type, $message)
  {
    $_SESSION['notice'] = array($type, $message);
  }

  function getNotice()
  {
    if ($this->noticeExists())
    {
      $notice = $_SESSION['notice'];
      unset($_SESSION['notice']);
      return $notice;
    }
    else
      return false;
  }

  function noticeExists()
  {
    return isset($_SESSION['notice']);
  }

  /*
   * redirect
   */
  function redirectTo($location)
  {
    $this->rendering = false;
    header("Location: $location");
    die();
  }

  /*
   * Sessions
   */
  function setSession($name, $data)
  {
    $_SESSION[$name] = $data;
  }

  function getSession($name)
  {
    return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
  }

  function unsetSession($name)
  {
    unset($_SESSION[$name]);
  }

  function userSignedIn()
  {
    return isset($_SESSION['user']);
  }

  function currentUser()
  {
    $user = unserialize( $this->getSession('user') );
    return UserModel::find( $user->id );
  }

  function requireAuthenticatedUser()
  {
    if (!$this->userSignedIn()) {
      $this->setNotice('error', 'Vous devez être connecté pour acceder à cette page');
      $this->redirectTo('/login');
    }
  }

  function getRequestFormat()
  {
    return split( ",", $_SERVER[ 'HTTP_ACCEPT' ] )[ 0 ];
  }

}
