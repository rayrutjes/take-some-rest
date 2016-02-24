<?php

namespace RayRutjes\Tsr\Test\Integration;

use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;

abstract class IntegrationTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    private $connection = null;

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        if (null === $this->connection) {
            $config = include dirname(__FILE__) . '/../../config.php';
            $pdo = new \PDO($config['db_dsn'], $config['db_username'], $config['db_password']);
            $this->connection = $this->createDefaultDBConnection($pdo, $config['db_name']);
        }

        return $this->connection;
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(dirname(__FILE__).'/fixtures.yml');
    }
}