<?php 
class Form
{  
  private $data,
          $name;
  public $errors = array();

  public function __construct($name, $obj)
  {
    $this->name = $name;
    $this->errors = $obj->errors;
    $this->obj = $obj;
  }

  public function input($type, $field, $label=null, $attributes=array())
  {
    $errorClass = '';
    $errorHint  = '';
    $inputValue = '';

    $method = $field;

    if ($type != "password")
      $inputValue = $this->obj->$method;

    if (array_key_exists($field, $this->errors)) {
      $errorClass .= " error";

      $errorHint .= '<span class="help-inline">';
      foreach ($this->errors[$field] as $msg)
        $errorHint .= $msg.' ';
      $errorHint .= '</span>';
    }

    $inputID = $this->name.'_'.$field;
    $buffer  = '<div class="control-group'.$errorClass.'">';
    if ($label)
      $buffer .= '<label class="control-label" for="'.$inputID.'">'.$label.'</label>';
    $buffer .= '  <div class="controls">';
    $buffer .= '    <input type="'.$type.'" id="'.$inputID.'" name="'.$this->name.'['.$field.']" value="'.$inputValue.'" />';
    $buffer .= $errorHint;
    $buffer .= '  </div>';
    $buffer .= '</div>';

    return $buffer;
  }
}
?>