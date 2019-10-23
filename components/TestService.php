<?php


namespace app\components;

class TestService
{
  private $testProperty = "This is test property";

  public function getTestProperty() {
    return $this->testProperty;
  }
}