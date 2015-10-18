<?php
/**
 * This file contains the main app code for the Mars
 * Rover problem.
 *
 * @author Tassos Koutlas <tassos.koutlas@gmail.com>
 */
namespace MarsRover\App;

use MarsRover\Rover\Rover;
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
  private $grid = array();
  private $init = false;
  private $initRover = false;
  private $roverCommands = array();

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
        $commands = $this->roverCommands;
        $grid = $this->grid;

        if ($this->initRover) {
          
          $this->cli->blue('Rover starts from: ' . $commands['position'] . '.');
          $this->cli->blue('It will execute move command: ' . $commands['movement'] . '.');

          $rover = new Rover($commands, $grid);
          $rover->execute();

          $this->cli->green('Rover moved to: ' . $rover->destination);

          // Usually PHP garbage collection takes care of this but
          // needs to be unset in large loops. See more at
          // http://php.net/manual/en/function.unset.php#105980.
          unset($rover);
          
          $this->roverCommands = array();
          $this->initRover = false;

        }
        
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
   */
  private function validate($command)
  {

    $size = strlen($command);

    if ($size == 2 && is_numeric($command)) {
      $this->validateGridCommand($command);
    } else {
      $this->validateRoverCommand($command);
    }

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
   * This function splits rover commands into position and movement
   * and populates the private argument $roverCommands. When that
   * array has both values then a new Rover may be initialised.
   *
   * @param string $command
   *   The input command from the user.
   *
   * @throws Exception
   *   Throws an exception if the grid is not initialised first.
   */
  private function validateRoverCommand($command)
  {

    $size = strlen($command);

    if ($this->init == false) {
      throw new Exception('Need to initialise the grid first');
    }

    if (is_numeric($command[0])) {
      
      $this->roverCommands['position'] = $command;
      $this->cli->green('Rover position set.');
      
    } else {
      
      $this->roverCommands['movement'] = $command;
      $this->cli->green('Rover movement set.');
      
    }

    if (count($this->roverCommands) == 2) {
      $this->initRover = true;
    }
    
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
    $this->grid['x'] = $split[0];
    $this->grid['y'] = $split[1];
    $this->cli->green('Grid initalised at ' . $split[0] . 'x' . $split[1] . '.');
    
  }

}
