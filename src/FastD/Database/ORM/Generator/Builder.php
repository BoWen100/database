<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Generator;

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\ORM\Parser\DBParser;
use FastD\Database\ORM\Parser\TableParser;

/**
 * Class Builder
 *
 * @package FastD\Database\ORM\Mapper
 */
class Builder
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var DBParser
     */
    protected $parser;

    /**
     * Builder constructor.
     *
     * @param DriverInterface|null $driverInterface
     */
    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->driver = $driverInterface;

        $this->parser = new DBParser($driverInterface);
    }

    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @return \FastD\Database\ORM\Parser\TableParser[]
     */
    public function getTables()
    {
        return $this->parser->getTables();
    }

    /**
     * @param array $table
     * @return $this
     */
    public function addTable(array $table)
    {
        if (!isset($table['table'])) {
            throw new \RuntimeException('Table name is undefined.');
        }

        if ($this->parser->hasTable($table['table'])) {
            $this->parser->getTable($table['table'])->setNewFields($table);
        } else {
            $table = new TableParser(
                $this->driver,
                $table['table'],
                $table,
                $this->parser->hasTable($table['table'])
            );
            $this->parser->addTable($table);
        }

        return $this;
    }

    /**
     * @param array $tables
     * @return $this
     */
    public function setTables(array $tables)
    {
        foreach ($tables as $table) {
            $this->addTable($table);
        }

        return $this;
    }

    public function updateTables()
    {
        $sqlArray = [];
        foreach ($this->getTables() as $table) {
            $sql = $table->makeSQL();
            if (!empty($sql)) {
                $sqlArray[] = $sql;
            }
        }
        echo '<pre>';
        print_r($sqlArray);
        return true;
    }

    /**
     * @param        $dir
     * @param string $namespace
     */
    public function buildEntity($dir, $namespace = '')
    {
        foreach ($this->getTables() as $table) {
//            $entity = new EntityBuilder($struct, $dir);
//            $entity->buildEntity($namespace.$struct->getTable());
        }
    }
}