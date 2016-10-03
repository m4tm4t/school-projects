<?php
class CommentsController extends ApplicationController
{
  public function create()
  {
    $comment = new CommentModel;
    $comment->username = $this->data->username;
    $comment->body = $this->data->body;
    $comment->recipe_id = $this->data->recipe_id;
    $comment->note = $this->data->note;

    if ($comment->save()) {
      $this->addVar('json', $comment);
    }
  }
}
