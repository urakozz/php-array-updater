<?php
/**
 * @author Yury Kozyrev <ykmship@yandex-team.ru>
 */

namespace Kozz\Tests;


use Kozz\Components\ArrayUpdater\ArrayUpdater;
use Kozz\Helper\ArrayHelper\ArrayPathHelper;

class ArrayUpdaterTest extends \PHPUnit_Framework_TestCase
{
  protected $array = [];
  protected $arrayMulti = [];

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

    $this->arrayMulti = array(
      'this' => array(
        array(
          'the' => array(
            'path' => [
              1,2,3,4,5
            ]
          )
        ),
        array(
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
    $array = $this->array;
    $array = ArrayUpdater::from($array)->node('this')->node('is')->node('the')->node('path')->all()->replace(1, 100);
    $expected = array(
      'this' => array(
        'is' => array(
          'the' => array(
            'path' => [
              100,2,3,4,5
            ]
          )
        )
      )
    );
    $this->assertSame($expected, $array);
  }

  public function testUpdateAssoc()
  {
    $array = $this->arrayMulti;
    $array = ArrayUpdater::from($array)->node('this')->all()->node('the')->node('path')->all()->replaceAssoc([1=>100, 3=>300]);
    $expected = array(
      'this' => array(
        array(
          'the' => array(
            'path' => [
              100,2,300,4,5
            ]
          )
        ),
        array(
          'the' => array(
            'path' => [
              100,2,300,4,5
            ]
          )
        )
      )
    );
    $this->assertSame($expected, $array);
  }

  public function testArrayPathHelper()
  {
    $array = $this->array;
    ArrayPathHelper::pathSet($array, ['this', 'is', 'the', 'path', 0], 100);
    $expected = array(
      'this' => array(
        'is' => array(
          'the' => array(
            'path' => [
              100,2,3,4,5
            ]
          )
        )
      )
    );
    $this->assertSame($expected, $array);

    $array = [];
    ArrayPathHelper::pathSet($array, ['this', 'is', 'the', 'path', 0], 100);
    $expected = array(
      'this' => array(
        'is' => array(
          'the' => array(
            'path' => [
              100
            ]
          )
        )
      )
    );
    $this->assertSame($expected, $array);

  }
} 