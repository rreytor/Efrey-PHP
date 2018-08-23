<?php
/**
 * @desc        Class Easy_GenericModel, esta clase es para no tener que definir fisicamente los modelos.
 * @author:     Reynier Reytor Vega
 * @copyright   Easycubasoft 10/06/2015
 */


class Easy_GenericModel extends Easy_Model{

    private $table;

    function __construct($table)
    {
        parent::__construct($table);
        $this->table = $table;
    }

    function checkTable()
    {
        $tables = $this->_db->MetaTables('TABLES');

        if(in_array($this->table,$tables))
            return true;
        else
            return false;

    }

} 