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
            die('Error:' . $e->getMessage());
        }
    }

    public static function query(string $req, array $values = [])
    {
        $prepare = self::$bdd->prepare($req);
        $prepare->execute($values);
        return $prepare;
    }

    public static function execute(string $req, array $values)
    {
        self::$bdd->prepare($req)->execute($values);
    }


}


//$link = mysql_connect($this->user, $this->host, $this->pass, $this->db);
//return $link;