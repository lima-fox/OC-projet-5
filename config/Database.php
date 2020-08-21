<?php
 
Class Database
{
    private static $bdd;

    public static function connect()
    {
        try
        {
            self::$bdd = new \PDO('mysql:host=localhost;dbname=blog5;charset=utf8', 'homestead', 'secret');
        }
        catch(Exception $e)
        {
            die('Erreur:' . $e->getMessage());
        }
    }

    public static function query(string $req)
    {
        return self::$bdd->query($req);     
    }
}


//$link = mysql_connect($this->user, $this->host, $this->pass, $this->db);
//return $link;