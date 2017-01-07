<?php
class admin{
public $name;
public $password;
public $f_id;
public $email;


public function __construct($n, $p, $f, $e){
$this->name=$n;
$this->password=$p;
$this->f_id=$f;
$this->email=$e;
}

public function hashit() {
  return password_hash($this->password, PASSWORD_DEFAULT);
}
}
?>
