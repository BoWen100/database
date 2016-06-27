<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Tests\ORM;

use FastD\Database\Tests\Fixture_Database_TestCast;
use Test\Dbunit\Models\BaseModel;

class ModelTest extends Fixture_Database_TestCast
{
    public function testModel()
    {
        $model = new BaseModel($this->getLocalDriver());

        $this->assertEquals(2, $model->count());
        $this->assertEquals(1, $model->count(['name' => 'janhuang']));
    }
}