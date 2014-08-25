<?php
/**
 * @author Yury Kozyrev <ykmship@yandex-team.ru>
 */

namespace Kozz\Components\ArrayUpdater;

use PhpOption\None;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ArrayUpdater
{

  protected $data = [];

  protected $path = [];

  public function __construct(array &$data)
  {
    $this->data = $data;
  }

  public static function from(array &$data)
  {
    return new self($data);
  }

  public function node($name)
  {
    $this->path[] = $name;
    return $this;
  }

  public function all()
  {
    $this->path[] = None::create();
    return $this;
  }

  public function replace($search, $replace)
  {
    $this->replaceAssoc([$search, $replace]);
  }

  public function replaceAssoc(array $association)
  {
    $data = $this->data;
    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($data));
    $it       =
      new \CallbackFilterIterator($iterator, function (
        $current,
        $key,
        RecursiveIteratorIterator $iterator
      ) use (&$data, $association) {
        if ($iterator->getDepth() === 3 && isset($association[$current])) {
          $key0 = $iterator->getSubIterator(0)->key();
          $key1 = $iterator->getSubIterator(1)->key();
          $key2 = $iterator->getSubIterator(2)->key();
          $key3 = $iterator->getSubIterator(3)->key();
          if ('dependency' === $key0 && 'c_ids' === $key2) {
            $data[$key0][$key1][$key2][$key3] = $association[$current];
          }
        }
      });

    iterator_to_array($it);
    $this->data = $data;
  }

  public function arraySet(&$arr, array $path, $value)
  {
    $cur =& $arr;
    foreach ($path as $segment)
    {
      if (!isset($cur[$segment]))
      {
        $cur[$segment] = [];
      }

      $cur =& $cur[$segment];
    }
    $cur = $value;
    unset($cur);
  }

}