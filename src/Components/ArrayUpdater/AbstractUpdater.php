<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 30/08/14
 */

namespace Kozz\Components\ArrayUpdater;


use PhpOption\None;

abstract class AbstractUpdater
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

  abstract public function replaceAssoc(array $association);

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
    return new static($data);
  }

  /**
   * @param $name
   *
   * @return $this
   */
  public function node($name)
  {
    $this->path[] = $name;
    $this->clearTmpVars();
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
   * @return void
   */
  protected function clearTmpVars()
  {
    $this->count = [];
  }
} 