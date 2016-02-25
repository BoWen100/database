<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午5:53
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Builder;

use FastD\Database\Builder\Field;

class FieldTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $name = new Field('name', 'varchar');

        $this->assertEquals('name', $name->getName());

        $this->assertEquals('varchar', $name->getType());

        $name = new Field('name', 'array', 20, 'true_name');

        $this->assertEquals('name', $name->getName());

        $this->assertEquals('varchar', $name->getType());

        $this->assertEquals('true_name', $name->getAlias());

        $this->assertEquals(20, $name->getLength());
    }
}
