<?php

namespace AcaShopBundle\Model;

use Simplon\Mysql\Mysql;

abstract class AbstractModel
{
    /**
     * @var Mysql
     */
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
}