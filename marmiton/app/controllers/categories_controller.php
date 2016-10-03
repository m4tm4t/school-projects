<?php
class CategoriesController extends ApplicationController
{
  public function index() {
    $categories = CategoryModel::getAll();
    $this->addVar( 'json', $categories );
  }
}
