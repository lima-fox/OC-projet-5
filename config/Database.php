<?php

Class Database
{
    private static $bdd;

    public static function connect()
    {

        $credentials = [
            'host'      => 'localhost',
            'user'      => 'homestead',
            'dbname'    => 'blog5',
            'password'  => 'secret'
        ];

        try
        {
            self::$bdd = new \PDO(
                'mysql:host='.$credentials['host'].';dbname='.$credentials['dbname'].';charset=utf8',
                $credentials['user'],
                $credentials['password']
            );
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

