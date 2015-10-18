<?php
/**
 * This file contains the main app code for the Mars
 * Rover problem.
 *
 * @author Tassos Koutlas <tassos.koutlas@gmail.com>
 */
namespace MarsRover\App;

use League\CLImate\CLImate;
use Exception;

/**
 * The main app class.
 *
 * This class is responsible for initialising and parsin initial
 * commands and then assign the commands to appropriate methods
 * for execution. It uses a Rover object to run commands on Mars
 * Rovers.
 */
class App
{

  private $cli;
  private $init = false;

  public function __construct()
  {
    
    $this->cli = new CLImate();
    
  }

  /**
   * Starts the application.
   */
  public function start()
  {

    $input = $this->cli->input('Please enter position/command: ');
    $input->defaultTo('You need to enter a command or a position.');
    
    while($command = $input->prompt()) {

      try {

        $this->validate($command);
        
      } catch(Exception $e) {

        $this->cli->red($e->getMessage());
        
      }

    }
    
  }

  /**
   * Validates a command.
   *
   * @param string $command
   *   The input command from the user.
   *
   * @return void
   *
   * @throws Exception
   *   Throws an exception if command is less than 2 characters.
   */
  private function validate($command)
  {

    $size = strlen($command);

    if ($size == 2) {
      $this->validateGridCommand($command);
      return;
    }

    if ($size >= 3) {
      $this->validateRoverCommand($command);
      return;
    }

    throw new Exception('Command is not correct.');
    return;
    
  }

  /**
   * Validates an initialisation command and initialises the grid.
   *
   * @param string $command
   *   The input command from the user.
   *
   * @return void
   *
   * @throws Exception
   *   Throws exception if grid already initialised or command is not
   *   two numbers.
   */
  private function validateGridCommand($command)
  {

    $init = $this->init;

    if ($init) {
      throw new Exception('Grid already initialised.');
      return;
    }
    
    if (!is_numeric($command)) {
      throw new Exception('Initialise command not correct');
    }
    else {
      $this->initialiseGrid($command);
      $this->init = true;
    }

  }

  /**
   * Validates an Rover command.
   *
   * @param string $command
   *   The input command from the user.
   */
  private function validateRoverCommand($command)
  {
    
    $this->cli->green('validateRoverCommand');
    
  }

  /**
   * Initialises the grid.
   *
   * @param string $command
   *   The input command from the user.
   */
  private function initialiseGrid($command)
  {

    $split = str_split($command);
    $this->cli->green('Grid initalised at ' . $split[0] . 'x' . $split[1] . '.');
    
  }

}
