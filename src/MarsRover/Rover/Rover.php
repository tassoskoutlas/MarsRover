<?php
/**
 * This file contains the Rover part for the Mars Rover problem.
 *
 * @author Tassos Koutlas <tassos.koutlas@gmail.com>
 */
namespace MarsRover\Rover;

/**
 * The Rover class.
 *
 * It deploys and moves rovers on Mars.
 */
class Rover
{

  private $position;
  private $movement;
  private $X;
  private $Y;
  private $O;

  public $destination;
  

  /**
   * Constructor for Rover class.
   */
  public function __construct($commands)
  {
    $this->position = $commands['position'];
    $this->movement = $commands['movement'];
  }

  /**
   * Execute commands on the Rover.
   */
  public function execute()
  {

    $this->validate($this->position, 'position');
    $this->validate($this->movement, 'movement');

    //$this->at($position);
    //$this->to($movement);
    
  }

  /**
   * Validates Rover commands.
   *
   * It validates a Rover command according to the $switch that is
   * passed to it. The $p accepted is 'position' and 'movement'.
   *
   * @param string $command
   *   A user command.
   *
   * @param string $op
   *   An $op can be either 'position' or 'movement' and is used to
   *   differentiate validation rules.
   */
  private function validate($command, $op)
  {

    switch ($op) {

    case 'position':
      var_dump($command);
      break;

    case 'movement':
      var_dump($command);
      break;

    }
    
  }

  
  
}