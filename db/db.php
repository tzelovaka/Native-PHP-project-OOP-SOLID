<?php

class DatabaseConnection
{
    private $connection;

    public function __construct($config) {
        $this->connect($config);
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    private function connect($config) {
        if (!is_array($config)) {
            throw new InvalidArgumentException("Configuration must be an array");
        }

        $this->connection = new mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database']
        );

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    private function disconnect()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);

        if ($result === false) {
            echo "Error: " . $this->connection->error . "<br>";
        }

        return $result;
    }

    public function prepareAndExecute($sql, $types, ...$params)
    {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            echo "Preparation failed: " . $this->connection->error . "<br>";
            return false;
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            echo "Execution failed: " . $stmt->error . "<br>";
            return false;
        }

        if (!$stmt->field_count) {
            $stmt->close();
            return true;
        }

        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }
}