<?php
/*
 * Auto load classes
 */
function loadClass($className) {
  if (preg_match('/^(\w+)Controller$/', $className, $matche)) {
    require_once ROOT_PATH.'/app/controllers/'.strtolower($matche[1]).'_controller.php';
  }
  else if (preg_match('/^(\w+)Model$/', $className, $matche)) {
    require_once ROOT_PATH.'/app/models/'.strtolower($matche[1]).'.php';
  }
  else {
    require_once ROOT_PATH.'/classes/'.strtolower($className).'.class.php';
  }
}
spl_autoload_register('loadClass');

/*
 * define controller/Actions
 */
function routeTo($controller, $action, $params=array())
{
  define('CONTROLLER', $controller);
  define('ACTION', $action);
  define('PARAMS', serialize($params));
}

/*
 * Views helpers
 */
function stylesheet_tag($file)
{
  return "<link type='text/css' rel='stylesheet' href='/css/$file'>\n";
}

function javascript_tag($file)
{
  return "<script src='/js/$file'></script>";
}

function linkTo($title, $link, $options=array())
{
  $class = isset($options['class']) ? 'class="'.$options['class'].'"' : null;
  return "<a href='$link'$class>$title</a>\n";
}

function toDate($rawDate)
{
  $date = strtotime($rawDate);
  $date = date('Y-m-d H:i:s', $date);
  return (string) $date;
}

function getUnitTypes()
{
  return array(
    array(
      'name'      => 'quantity',
      'unit_type' => 1
    ),
    array(
      'name'      => 'volume',
      'unit_type' => 2,
      'units' => array(
        'ML' => 1,
        'CL' => 2,
        'L'  => 3,
        'TEASPOON'   => 4,
        'TABLESPOON' => 5
      )
    ),
    array(
      'name'      => 'weight',
      'unit_type' => 3,
      'units' => array(
        'MG' => 1,
        'G'  => 2,
        'KG' => 3
      )
    ),
    array(
      'name'      => 'length',
      'unit_type' => 4,
      'units' => array(
        'MM' => 1,
        'CM' => 2,
        'M'  => 3
      )
    )
  );
}
