<?php


namespace App;


class Comment extends \Database
{
    private int $id;
    private int $users_id;
    private int $post_id;
    private string $date_comment;
    private string $content;
    private User $user;

    /**
     * Comment constructor.
     * @param int $id
     * @param int $users_id
     * @param int $post_id
     * @param string $date_comment
     * @param string $content
     */
    public function __construct(int $id, int $users_id, int $post_id, string $date_comment, string $content)
    {
        $this->id = $id;
        $this->users_id = $users_id;
        $this->post_id = $post_id;
        $this->date_comment = $date_comment;
        $this->content = $content;
        $this->user = User::getById($users_id);
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }


    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return string
     */
    public function getDateComment(): string
    {
        return $this->date_comment;
    }

    /**
     * @param string $date_comment
     */
    public function setDateComment(string $date_comment): void
    {
        $this->date_comment = $date_comment;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public static function getByPostId($post_id) : array
    {
        self::connect();
        $results = self::query("SELECT * FROM `comments` WHERE `post_id` =" . $post_id);

        $comments = [];

        foreach($results AS $result)
        {
            $comment = new Comment($result['id'], $result['users_id'], $result['post_id'], $result['date_comment'], $result['content']);
            $comments[] = $comment;
        }
        return $comments;

    }


}