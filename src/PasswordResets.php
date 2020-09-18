<?php


namespace App;


class PasswordResets extends \Database
{
    private int $id;
    private int $users_id;
    private string $mail;
    private string $hash_pass;

    /**
     * Password_resets constructor.
     * @param int $id
     * @param int $users_id
     * @param string $mail
     * @param string $hash_pass
     */
    public function __construct(int $id, int $users_id, string $mail, string $hash_pass)
    {
        $this->id = $id;
        $this->users_id = $users_id;
        $this->mail = $mail;
        $this->hash_pass = $hash_pass;
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
     * @return int
     */
    public function getUsersId(): int
    {
        return $this->users_id;
    }

    /**
     * @param int $users_id
     */
    public function setUsersId(int $users_id): void
    {
        $this->users_id = $users_id;
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
    public function getHashPass(): string
    {
        return $this->hash_pass;
    }

    /**
     * @param string $hash_pass
     */
    public function setHashPass(string $hash_pass): void
    {
        $this->hash_pass = $hash_pass;
    }

    public static function create(int $users_id, string $mail, string $hash_pass)
    {
        self::connect();

        self::execute("INSERT INTO `password_resets` (`users_id`, `mail`, `hash_pass`)
                            VALUES (:users_id, :mail, :hash_pass)",
                            [
                                'users_id' => $users_id,
                                'mail' => $mail,
                                'hash_pass' => $hash_pass
                            ]
        );
    }


}

