<?php
/**
 * @author Yury Kozyrev <ykmship@yandex-team.ru>
 */

namespace Kozz\Components\ArrayUpdater;

use Kozz\Helper\ArrayHelper\ArrayPathHelper;
use PhpOption\None;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

/**
 * Class ArrayUpdater
 *
 * @package Kozz\Components\ArrayUpdater
 */
class ArrayUpdater
{

  /**
   * @var array
   */
  protected $data = [];

  /**
   * @var array
   */
  protected $path = [];

  /**
   * @var
   */
  protected $count;

  /**
   * @param array $data
   */
  public function __construct(array $data)
  {
    $this->data = $data;
  }

  /**
   * @param array $data
   *
   * @return ArrayUpdater
   */
  public static function from(array $data)
  {
    return new self($data);
  }

  /**
   * @param $name
   *
   * @return $this
   */
  public function node($name)
  {
    $this->path[] = $name;
    $this->count = null;
    return $this;
  }

  /**
   * @return $this
   */
  public function all()
  {
    return $this->node(None::create());
  }

  /**
   * @param $search
   * @param $replace
   *
   * @return array
   */
  public function replace($search, $replace)
  {
    return $this->replaceAssoc([$search, $replace]);
  }

  /**
   * @param array $association
   *
   * @return array
   */
  public function replaceAssoc(array $association)
  {
    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->data));
    $it       =
      new \CallbackFilterIterator($iterator, function (
        $current,
        $key,
        RecursiveIteratorIterator $iterator
      ) use ($association) {
        if ($iterator->getDepth() + 1 === $this->countNodes() && isset($association[$current]))
        {
          $currentPath = ArrayPathHelper::getPath($iterator);
          $filter      = array_filter($this->path, function($value){
              return !$value instanceof None;
            });
          $diff        = array_diff_assoc($currentPath, $filter);
          $keys        = array_intersect_key($filter, $diff);

          if(!$keys)
          {
            ArrayPathHelper::pathSet($this->data, $currentPath, $association[$current]);
          }
        }
      });

    iterator_to_array($it);
    return $this->data;
  }


  /**
   * @return int
   */
  protected function countNodes()
  {
    if(null === $this->count)
    {
      $this->count = count($this->path);
    }
    return $this->count;
  }
}