<?php
namespace App;

class User extends \Database
{
    private int $id;
    private string $login;
    private  string $pass;
    private string $lastname;
    private string $firstname;
    private string $mail;
    private string $phone;
    private string $category;
    private string $hash;
    private int $active;

    /**
     * Users constructor.
     * @param int $id
     * @param string $login
     * @param string $pass
     * @param string $lastname
     * @param string $firstname
     * @param string $mail
     * @param string $phone
     * @param string $category
     * @param string $hash
     * @param int $active
     */
    public function __construct(int $id, string $login, string $pass, string $lastname, string $firstname, string $mail, string $phone, string $category, string $hash, int $active)
    {
        $this->id = $id;
        $this->login = $login;
        $this->pass = $pass;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->mail = $mail;
        $this->phone = $phone;
        $this->category = $category;
        $this->hash = $hash;
        $this->active = $active;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active): void
    {
        $this->active = $active;
    }




    public static function getByLogin(string $login) : ?User
    {
        self::connect();

        $result = self::query(sprintf("SELECT * FROM users WHERE login = '%s'", $login))->fetch();
        if($result)
        {
            $user = new User($result['id'],
                $result['login'],
                $result['pass'],
                $result['lastname'],
                $result['firstname'],
                $result['mail'],
                $result['phone'],
                $result['category'],
                $result['hash'],
                $result['active']);
            return $user;
        }
        else
        {
           return null;
        }


    }

    public static function getById(int $id) : ?User
    {
        self::connect();

        $result = self::query('SELECT * FROM users WHERE id = :id', ['id' => $id])->fetch();

        if (is_array($result))
        {
            $user = new User($result['id'],
                $result['login'],
                $result['pass'],
                $result['lastname'],
                $result['firstname'],
                $result['mail'],
                $result['phone'],
                $result['category'],
                $result['hash'],
                $result['active']);
            return $user;
        }
        else
        {
            return null;
        }

    }

    public static function count_users() : int
    {
        self::connect();

        $count = self::query("SELECT COUNT(*) AS total FROM `users`")->fetch();

        return $count['total'];
    }

    public static function count_login(string $login) : int
    {
        self::connect();

        $user_login = self::query("SELECT COUNT(*) AS result FROM users WHERE login = :login", ['login' => $login])->fetch();
        return $user_login['result'];
    }

    public static function create(string $login, string $pass, string $lastname, string $firstname, string $mail, string $phone, string $hash)
    {
        self::connect();

        self::execute("INSERT INTO `users`(`login`, `pass`, `lastname`, `firstname`, `mail`, `phone`, `category`, `hash`, `active`) 
                            VALUES (:login, :pass , :lastname, :firstname, :mail, :phone, :category, :hash, :active)",
                            ['login' => $login,
                                'pass' => $pass,
                                'lastname' => $lastname,
                                'firstname' => $firstname,
                                'mail' => $mail,
                                'phone' => $phone,
                                'category' => 'users',
                                'hash' => $hash,
                                'active' => 0]);
    }

    public static function active_mail(string $hash)
    {
        self::connect();

        self::execute("UPDATE `users` SET `active`= 1 WHERE `hash` = :hash", ['hash' => $hash]);
    }
}

