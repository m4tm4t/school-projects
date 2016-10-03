<?php

class HomeController extends ApplicationController
{

  // GET /
  public function index() {
    $data = array('foo' => 'bar');

    if ( $this->format == 'application/json' )
      $this->addVar( 'json', $data );
    else
      $this->addVar( 'data', $data );
  }

}

?>
