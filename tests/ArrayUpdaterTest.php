<?php
/**
 * @author Yury Kozyrev <ykmship@yandex-team.ru>
 */

namespace Kozz\Tests;


use Kozz\Components\ArrayUpdater\ArrayUpdater;

class ArrayUpdaterTest extends \PHPUnit_Framework_TestCase
{
  protected $array = [];

  protected function setUp()
  {
    $this->array = array(
      'this' => array(
        'is' => array(
          'the' => array(
            'path' => [
              1,2,3,4,5
            ]
          )
        )
      )
    );
  }

  public function testUpdate()
  {
    ArrayUpdater::from($this->array)->node('this')->node('is')->node('the')->node('path')->all()->replace(1, 100);
    var_dump($this->array);
  }
} 