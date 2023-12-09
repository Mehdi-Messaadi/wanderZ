 <?php

    abstract class Dbh
    {
        private $host;
        private $user;
        private $pwd;
        private $dbName;
        protected $pdo;

        public function __construct($host, $user, $pwd, $dbName)
        {
            $this->host = $host;
            $this->user = $user;
            $this->pwd = $pwd;
            $this->dbName = $dbName;
        }

        abstract protected function connect();

        public function getPDO()
        {
            return $this->pdo;
        }

        public function setHost($host)
        {
            $this->host = $host;
        }

        public function setUser($user)
        {
            $this->user = $user;
        }

        public function setPwd($pwd)
        {
            $this->pwd = $pwd;
        }

        public function setDbName($dbName)
        {
            $this->dbName = $dbName;
        }

        public function getHost()
        {
            return $this->host;
        }

        public function getUser()
        {
            return $this->user;
        }

        public function getPwd()
        {
            return $this->pwd;
        }

        public function getDbName()
        {
            return $this->dbName;
        }
    }
