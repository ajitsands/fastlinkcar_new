<?php

class SQLHelperClass
{

    /* ========================================
       BUILD WHERE CONDITIONS
    ======================================== */

    private static function buildWhere($where)
    {
        if (empty($where)) {
            return array("sql" => "", "values" => array());
        }

        $logic = isset($where['logic']) ? strtoupper($where['logic']) : 'AND';
        $conditions = isset($where['conditions']) ? $where['conditions'] : $where;

        $clauses = array();
        $values = array();

        foreach ($conditions as $cond) {

            if (isset($cond['conditions'])) {

                $nested = self::buildWhere($cond);

                if ($nested['sql'] != '') {
                    $clauses[] = "(" . $nested['sql'] . ")";
                    $values = array_merge($values, $nested['values']);
                }

            } else {

                $column = $cond['column'];
                $operator = strtoupper($cond['operator']);
                $value = $cond['value'];

                switch ($operator) {

                    case 'IN':

                        if (!is_array($value) || empty($value)) {
                            continue 2;
                        }
                    
                        $placeholders = implode(",", array_fill(0, count($value), "?"));
                        $clauses[] = "$column IN ($placeholders)";
                        $values = array_merge($values, $value);
                    
                        break;
                    
                    case 'BETWEEN':
                    
                        if (!is_array($value) || count($value) != 2) {
                            continue 2;
                        }
                    
                        $clauses[] = "$column BETWEEN ? AND ?";
                        $values = array_merge($values, $value);
                    
                        break;

                    default:

                        $clauses[] = "$column $operator ?";
                        $values[] = $value;

                        break;
                }
            }
        }

        $sql = implode(" $logic ", $clauses);

        return array(
            "sql" => $sql,
            "values" => $values
        );
    }


    /* ========================================
       BUILD ORDER BY
    ======================================== */

    private static function buildOrder($order)
    {
        if (empty($order)) {
            return "";
        }

        $clauses = array();

        foreach ($order as $column => $dir) {

            $dir = strtoupper($dir) == "DESC" ? "DESC" : "ASC";

            $clauses[] = "$column $dir";
        }

        return " ORDER BY " . implode(",", $clauses);
    }


    /* ========================================
       BUILD LIMIT OFFSET
    ======================================== */

    private static function buildLimit($limit, $offset)
    {
        if ($limit == null) {
            return "";
        }

        $sql = " LIMIT " . intval($limit);

        if ($offset != null) {
            $sql .= " OFFSET " . intval($offset);
        }

        return $sql;
    }


    /* ========================================
       BUILD JOIN
    ======================================== */

    private static function buildJoin($joins)
    {
        if (empty($joins)) {
            return "";
        }

        $sql = "";

        foreach ($joins as $join) {

            $type = isset($join['type']) ? strtoupper($join['type']) : "INNER";

            $table = $join['table'];

            $on = isset($join['on']) ? $join['on'] : "";

            $sql .= " $type JOIN $table";

            if ($on != "") {
                $sql .= " ON $on";
            }
        }

        return $sql;
    }


    /* ========================================
       SELECT
    ======================================== */

    public static function select($table, $options = array())
    {

        $joins = self::buildJoin(isset($options['joins']) ? $options['joins'] : array());

        $where = self::buildWhere(isset($options['where']) ? $options['where'] : array());

        $order = self::buildOrder(isset($options['order_by']) ? $options['order_by'] : array());

        $limit = self::buildLimit(
            isset($options['limit']) ? $options['limit'] : null,
            isset($options['offset']) ? $options['offset'] : null
        );

        $sql = "SELECT * FROM $table" . $joins;

        if ($where['sql'] != "") {
            $sql .= " WHERE " . $where['sql'];
        }

        $sql .= $order . $limit;

        return array(
            "sql" => $sql,
            "values" => $where['values']
        );
    }


    /* ========================================
       INSERT
    ======================================== */

    public static function insert($table, $data)
    {

        $columns = array_keys($data);

        $placeholders = implode(",", array_fill(0, count($columns), "?"));

        $sql = "INSERT INTO $table (" . implode(",", $columns) . ") VALUES ($placeholders)";

        return array(
            "sql" => $sql,
            "values" => array_values($data)
        );
    }


    /* ========================================
       UPDATE
    ======================================== */

    public static function update($table, $data, $options = array())
    {

        $columns = array_keys($data);

        $set = array();

        foreach ($columns as $col) {
            $set[] = "$col = ?";
        }

        $setClause = implode(",", $set);

        $where = self::buildWhere(isset($options['where']) ? $options['where'] : array());

        $sql = "UPDATE $table SET $setClause";

        if ($where['sql'] != "") {
            $sql .= " WHERE " . $where['sql'];
        }

        return array(
            "sql" => $sql,
            "values" => array_merge(array_values($data), $where['values'])
        );
    }


    /* ========================================
       DELETE
    ======================================== */

    public static function delete($table, $options = array())
    {

        $where = self::buildWhere(isset($options['where']) ? $options['where'] : array());

        $sql = "DELETE FROM $table";

        if ($where['sql'] != "") {
            $sql .= " WHERE " . $where['sql'];
        }

        return array(
            "sql" => $sql,
            "values" => $where['values']
        );
    }


    /* ========================================
       STORED PROCEDURE
    ======================================== */

    public static function procedure($procedureName, $params = array())
    {

        $values = array();

        $placeholders = "";

        if (!empty($params)) {

            $placeholders = implode(",", array_fill(0, count($params), "?"));

            $values = array_values($params);
        }

        $sql = "CALL $procedureName($placeholders)";

        return array(
            "sql" => $sql,
            "values" => $values
        );
    }

}

?>