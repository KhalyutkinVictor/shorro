<?php

// Holds db connection
class Db {

    protected $name;
    protected $user;
    protected $pass;
    protected $host;
    protected $port;
    protected $connection;
    
    /**
     * @param $config
     */
    public function __construct($config) {
        
        if (!array_key_exists('name', $config))
            throw new \Exception('"name" should exist in //config.php in "db"');

        if (!array_key_exists('user', $config))
            throw new \Exception('"user" should exist in //config.php in "db"');

        if (!array_key_exists('pass', $config))
            throw new \Exception('"pass" should exist in //config.php in "db"');

        if (!array_key_exists('host', $config))
            throw new \Exception('"host" should exist in //config.php in "db"');

        $this->name = $config['name'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->host = $config['host'];
        $this->port = $config['port'] ?? 3306;

        $this->connection = new mysqli(
            $this->host . ':' . $this->port,
            $this->user,
            $this->pass,
            $this->name  
        );
    }

    // Run query
    public function runQuery($query) {
        
        $query = $this->connection->query($query);
        if (gettype($query) == 'boolean') {
            if (!$query)
                throw new \Exception($this->connection->error);
            return $query;
        }
        return $query->fetch_assoc();
    }

}

class Model {

    protected $query;

    /**
     * Make query
     * @param $query
     * @return Model
     */
    public function setQuery($query) {
        $this->query = $query;
        return $this;
    }

    //run query
    public function run() {
        global $App;
        if ($this->query === null)
            return;
        return $App->db->runQuery($this->query);
    }

}