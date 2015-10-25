<?php

namespace AcaShopBundle\Db;

use \mysqli;
use \Exception;

/**
 * Class Database
 * @package AcaShopBundle\Db
 */
class Database
{
    /**
     * @var mysqli
     */
    protected $db;

    public function __construct()
    {

        // don't want to hard code these below
        // use values from login form
        // and prevent sql injection
        // want all queries to go through one place
        // try on our own first, later will use a package to make it easy
        // $username = 'root';
        // $password = 'root';
        // $host = 'localhost';
        // $port = 3306;

        $this->db = new mysqli("localhost", "root", "root", "acashop");
        if ($this->db->connect_errno) {
            throw new Exception(
                "Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . $this->db->connect_error
            );
        }

        // Connect to the DB??
        // go to php.net and investigate mysqli family
        // of functions
    }   // end of __construct

    // This method will accept a SQL query and return
    // any matching rows

    /**
     * Get many rows from the DB
     * @param string $query SQL query
     * @return array Assoc array of data from DB
     */
    public function fetchRowMany($query)
    {
        $return = [];
        $result = $this->db->query($query);

        while ($row = $result->fetch_assoc()) {
            $return[] = $row;
        }

        return $return;
    }
}   // end of class Database


// want to instantiate class in processloginaction method i default
// $db = new Database();
// also add use Database and it will autofill
// use Aca\Bundle\