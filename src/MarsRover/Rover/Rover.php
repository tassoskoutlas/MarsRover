<?php
/**
 * This file contains the Rover part for the Mars Rover problem.
 *
 * @author Tassos Koutlas <tassos.koutlas@gmail.com>
 */
namespace MarsRover\Rover;

use Exception;

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
  private $orientations = array('N', 'E', 'S', 'W');
  private $movements = array('L', 'R', 'M');
  
  public $destination;
  

  /**
   * Constructor for Rover class.
   */
  public function __construct($commands, $grid)
  {
    $this->position = $commands['position'];
    $this->movement = $commands['movement'];
    $this->grid['x'] = $grid['x'];
    $this->grid['y'] = $grid['y'];
  }

  /**
   * Execute commands on the Rover.
   */
  public function execute()
  {

    $this->validate($this->position, 'position');
    $this->validate($this->movement, 'movement');
    
    $this->at($this->position);
    $this->to($this->movement);
    $this->destination = implode($this->getCurrentPosition());
    
  }

  /**
   * Puts a Rover at the specified position.
   *
   * @param string $position
   *   A user specified string with positioning information.
   */
  private function at($position)
  {
    
    $this->X = $position[0];
    $this->Y = $position[1];
    $this->O = $position[2];
    
  }

  /**
   * Moves a Rover accroding to the specified movement command.
   *
   * @param string $movement
   *   A user specified string with movement information.
   */
  private function to($movement)
  {

    $commands = str_split($movement);

    foreach ($commands as $command) {
      $this->move($command);
    }

  }

  /**
   * Returns current position and orientation.
   *
   * @return array $current
   *   An array with planar (x,y) values and orientation information.
   */
  private function getCurrentPosition()
  {

    $current = array();

    $current['x'] = $this->X;
    $current['y'] = $this->Y;
    $current['o'] = $this->O;

    return $current;
  }

  /**
   * Execute a step of a move command.
   *
   * @param string $command.
   *   A string of one character to execute a move command.
   */
  private function move($command)
  {
    
    switch ($command) {

    case 'L':
      $this->turnLeft();
      break;

    case 'R':
      $this->turnRight();
      break;

    case 'M':
      $this->moveForward();
      break;

    }
    
  }

  /**
   * Returns the index of current orientation.
   *
   * Kappa is the position of the current orientation from the
   * orientations array. It can be used to compute the left and
   * right values when orientation change commants are issued.
   *$climate->border();
   * @param array $current
   *   An array that contains current (x,y) and orientation values.
   *
   * @return int $kappa
   *   An integer representing the position of the current orientation
   *   in orientations array.
   */ 
  private function getKappa($current)
  {
    
    $o = $current['o'];
    $kappa = array_search($o, $this->orientations);
    return $kappa;
    
  }

  /**
   * Turns the Rover right from its current orientation.
   */
  private function turnRight()
  {

    $current = $this->getCurrentPosition();
    $kappa = $this->getKappa($current);

    if ($kappa + 1 == 4) {
      $kappa = 0;
    } else {
      $kappa = $kappa + 1;
    }
    
    $this->O = $this->orientations[$kappa];
    
  }

  /**
   * Turns the Rover left from its current orientation.
   */
  private function turnLeft()
  {

    $current = $this->getCurrentPosition();
    $kappa = $this->getKappa($current);

    if ($kappa == 0) {
      $kappa = 3;
    } else {
      $kappa = $kappa - 1;
    }
        
    $this->O = $this->orientations[$kappa];
    
  }

  /**
   * Move the Rover forward depending on orientation.
   */
  private function moveForward()
  {

    $current = $this->getCurrentPosition();
    $grid = $this->grid;

    switch ($current['o']) {

    case 'N':
      $current['y'] = $current['y'] + 1;
      break;

    case 'E':
      $current['x'] = $current['x'] - 1;
      break;

    case 'S':
      $current['y'] = $current['y'] - 1;
      break;

    case 'W':
      $current['x'] = $current['x'] + 1;
      break;

    }

    if ($current['x'] > $grid['x'] || $current['y'] > $grid['y']) {
      throw new Exception('Rover out of bounds. Start again with a larger grid.');
    }

    if ($current['x'] < 0 || $current['y'] < 0) {
      throw new Exception('Rover out of bounds. Start again with a larger grid.');
    }

    $position = implode($current);
    $this->at($position);
    
  }

  /**
   * Validates Rover commands.
   *
   * It validates a Rover command according to the switch that is
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
      $this->validatePosition($command);
      break;

    case 'movement':
      $this->validateMovement($command);
      break;

    }
    
  }

  /**
   * Validates a position command.
   *
   * @param string $command
   *   A user specified command.
   */
  private function validatePosition($command)
  {

    $regex = '/[0-9]{2}[' . implode($this->orientations) . ']/';

    if (!preg_match($regex, $command)) {
      throw new Exception('Position information not correct. Enter again.');


    }
    
  }

  /**
   * Validates a movement command.
   *
   * @param string $command
   *   A user specified command.
   */
  private function validateMovement($command)
  {
    
    $regex = '/[' . implode($this->movements) . ']+/';

    if (!preg_match($regex, $command)) {
      throw new Exception('Movement information not correct. Enter again.');
    }
    
  }

}
