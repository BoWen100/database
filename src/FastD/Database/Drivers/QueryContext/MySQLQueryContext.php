<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/17
 * Time: 下午11:21
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers\QueryContext;

/**
 * Class MySQLQueryContext
 *
 * @package FastD\Database\Drivers\QueryContext
 */
class MySQLQueryContext extends QueryContext
{
    /**
     * @var string
     */
    public $table;

    /**
     * @var string
     */
    public $where;

    /**
     * @var string
     */
    public $fields = '*';

    /**
     * @var string
     */
    public $limit;

    /**
     * @var string
     */
    public $join;

    /**
     * @var string
     */
    public $group;

    /**
     * @var string
     */
    public $order;

    /**
     * @var string
     */
    protected $having;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $keys;

    /**
     * @var string
     */
    protected $sql;

    /**
     * @const int
     */
    const CONTEXT_INSERT = 1;

    /**
     * @const int
     */
    const CONTEXT_UPDATE = 2;

    /**
     * @const int
     */
    const CONTEXT_DELETE = 3;

    /**
     * @param array $where
     * @return string
     */
    protected function parseWhere(array $where)
    {
        if (empty($where)) {
            return '';
        }

        $conditions = reset($where);

        $joint = '';

        if (is_array($conditions)) {
            $jointArr = array_keys($where);
            $joint = $jointArr[0];
            unset($jointArr);
        } else {
            $conditions = $where;
        }

        $where = [];

        foreach ($conditions as $key => $value) {
            if (false === strpos($value, ' ')) {
                $where[] = '`' . $key . '`=\'' . $value . '\'';
            } else {
                $where[] = '`' . $key . '`' . $value;
            }
        }

        if ('' !== $joint) {
            $joint = ' ' . $joint . ' ';
        }

        return implode($joint, $where);
    }

    /**
     * @param array $data
     * @param int   $operation
     * @return $this
     */
    public function data(array $data, $operation = QueryContext::CONTEXT_UPDATE)
    {
        switch ($operation) {
            case QueryContext::CONTEXT_INSERT:
                $keys = array_keys($data);
                $values = array_values($data);
                $this->keys = '(`' . implode('`,`', $keys) . '`)';
                $this->value = '(\'' . implode('\',\'', $values) . '\')';
                break;
            case QueryContext::CONTEXT_UPDATE:
            default:
                $values = [];
                foreach ($data as $name => $value) {
                    $values[] = '`' . $name . '`=\'' . $value . '\'';
                }
                $this->value = implode(',', $values);
        }

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = str_replace('``', '`', '`' . $table . '`');

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where = [])
    {
        $where = $this->parseWhere($where);

        if ('' != $where) {
            $this->where = ' WHERE ' . $where;
        }

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields = [])
    {
        if (array() !== $fields) {
            $this->fields = '';
            foreach ($fields as $value) {
                if (false === strpos($value, ' ')) {
                    $this->fields .= '`' . $value . '`,';
                } else {
                    $this->fields .= $value . ',';
                }
            }
            $this->fields = trim($this->fields, ',');
        } else {
            $this->fields = '*';
        }

        return $this;
    }

    /**
     * @param $group
     * @return $this
     */
    public function group($group)
    {
        $this->group = ' GROUP BY ' . $group;

        return $this;
    }

    /**
     * @param array $having
     * @return $this
     */
    public function having(array $having)
    {
        $this->having = ' HAVING ' . $this->parseWhere($having);

        return $this;
    }

    /**
     * @param $order
     * @return $this
     */
    public function order($order)
    {
        $this->order = ' ORDER BY ' . $order;

        return $this;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return $this
     */
    public function limit($limit = null, $offset = null)
    {
        $this->limit = null;

        if (null !== $limit) {
            $this->limit = ' LIMIT ' . (null === $offset ? '' : ($offset . ',')) . $limit;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function select()
    {
        $this->sql = 'SELECT ' . $this->fields . ' FROM ' . $this->table . $this->where . $this->group . $this->having . $this->order . $this->limit . ';';

        return $this;
    }

    /**
     * @return $this
     */
    public function update()
    {
        $this->sql = 'UPDATE ' . $this->table . ' SET ' . $this->value . $this->where . $this->limit . ';';

        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->sql = 'DELETE FROM ' . $this->table . $this->where . $this->limit . ';';

        return $this;
    }

    /**
     * @return $this
     */
    public function insert()
    {
        $this->sql = 'INSERT INTO ' . $this->table . $this->keys . ' VALUES ' . $this->value . ';';

        return $this;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        $this->fields   = '*';
        $this->where    = null;
        $this->group    = null;
        $this->limit    = null;
        $this->having   = null;
        $this->order    = null;
        $this->keys     = null;
        $this->value    = null;
        $this->join     = null;

        return $this->sql;
    }
}