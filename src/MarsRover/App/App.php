<?php

namespace MarsRover\App;

use League\CLImate\CLImate;

class App
{

  private $cli;

  public function __construct()
  {
    $this->cli = new CLImate();
  }
  
  public function start()
  {
    while($f = fgets(STDIN)){
      $this->cli->green($f);
    }
    
  }
  
}