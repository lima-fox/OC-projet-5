<?php
 
Class Database
{
    private $user ;
    private $host;
    private $pass ;
    private $db;
    private $bdd;

    public function __construct()
    {
        $this->user = "homestead";
        $this->host = "localhost";
        $this->pass = "secret";
        $this->db = "blog5";
        
    }
    public function connect()
    {
        try
        {
            $this->bdd = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8', $this->user, $this->pass);
        }
        catch(Exception $e)
        {
            die('Erreur:' . $e->getMessage());
        }
    }

    public function query(string $req)
    {
        return $this->bdd->query($req);     
    }
}


//$link = mysql_connect($this->user, $this->host, $this->pass, $this->db);
//return $link;