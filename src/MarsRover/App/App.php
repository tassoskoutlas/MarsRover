<?php

namespace MarsRover\App;

use League\CLImate\CLImate;
use Exception;

class App
{

  private $cli;
  private $init = false;

  public function __construct()
  {
    $this->cli = new CLImate();
  }
  
  public function start()
  {

    $input = $this->cli->input('Please enter position/command: ');
    $input->defaultTo('You need to enter a command or a position.');
    
    while($response = $input->prompt()) {

      try {
        $this->validate($response);        
      } catch(Exception $e) {
        $this->cli->red($e->getMessage());
      }

    }
    
  }

  private function validate($response)
  {

    $init = $this->init;
    $size = strlen($response);

    if ($size == 2 && is_numeric($response) && $init == false) {
      $this->validateGridCommand($response);
      return;
    }

    if ($size == 2 && is_numeric($response) && $init == true) {
      throw new Exception('Grid already initialised.');
      return;
    }

    if ($size >= 3) {
      $this->validateRoverCommand($response);
      return;
    }

    throw new Exception('Command is not correct.');
    return;
  }

  private function validateGridCommand($command)
  {

    $init = $this->init;

    if (strlen($command) > 2 && !is_numeric($command)) {
      throw new Exception('Initialise command not correct');
    }
    else {
      $this->initialiseGrid($command);
      $this->init = true;
    }

  }

  private function validateRoverCommand($command)
  {
    
    $this->cli->green('validateRoverCommand');
    
  }

  private function initialiseGrid($command)
  {

    $split = str_split($command);
    $this->cli->green('Grid initalised at ' . $split[0] . 'x' . $split[1] . '.');
    
  }

}
