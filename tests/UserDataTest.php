<?php

use Arrayy\Arrayy;

require_once __DIR__ . '/UserData.php';
require_once __DIR__ . '/CityData.php';

/**
 * Class UserDataTest
 */
class UserDataTest extends \PHPUnit\Framework\TestCase
{
  public function testSetAndGet()
  {
    $modelMeta = CityData::meta();

    $city = new CityData(
        [
            $modelMeta->name => 'Düsseldorf',
            $modelMeta->plz  => null,
        ]
    );

    // ---

    $modelMeta = UserData::meta();

    $model = new UserData(
        [
            $modelMeta->id        => 1,
            $modelMeta->firstName => 'Lars',
            $modelMeta->lastName  => 'Moelleken',
            $modelMeta->city      => $city,
        ]
    );

    static::assertInstanceOf(Arrayy::class, $model);
    static::assertSame('Moelleken', $model['lastName']);
    static::assertSame('Moelleken', $model[$modelMeta->lastName]);
    static::assertSame('Düsseldorf', $model->city->name);
    static::assertNull($model[3]);
  }

  /**
   * @depends testSetAndGet
   */
  public function testSetAndGetAgain()
  {
    $modelMeta = UserData::meta();

    $model = new UserData(
        [
            $modelMeta->id        => 2,
            $modelMeta->firstName => 'Lars1',
            $modelMeta->lastName  => 'Moelleken1',
        ]
    );

    static::assertInstanceOf(Arrayy::class, $model);
    static::assertSame('Moelleken1', $model['lastName']);
    static::assertSame('Moelleken1', $model[$modelMeta->lastName]);
    static::assertNull($model[3]);
  }

  /**
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Invalid type
   */
  public function testSetFail()
  {
    $modelMeta = UserData::meta();

    $model = new UserData(
        [
            $modelMeta->id => '3',
        ]
    );

    static::assertInstanceOf(Arrayy::class, $model);
  }

  /**
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage expected city to be of type {null|\CityData}, instead got value `stdClass` with type
   *                           {object}
   */
  public function testSetFailObject()
  {

    $modelMeta = UserData::meta();

    $model = new UserData(
        [
            $modelMeta->id        => 1,
            $modelMeta->firstName => 'Lars',
            $modelMeta->lastName  => 'Moelleken',
            $modelMeta->city      => (new \stdClass()),
        ]
    );

    static::assertInstanceOf(Arrayy::class, $model);
    static::assertSame('Moelleken', $model['lastName']);
    static::assertSame('Moelleken', $model[$modelMeta->lastName]);
    static::assertSame('Düsseldorf', $model->city->name);
    static::assertNull($model[3]);
  }
}
