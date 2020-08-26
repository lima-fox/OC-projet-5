<?php


namespace App;


class Comment extends \Database
{
    private int $id;
    private int $users_id;
    private int $post_id;
    private string $date_comment;
    private string $content;
    private int $status;
    private ?User $user;


    /**
     * Comment constructor.
     * @param int $id
     * @param int $users_id
     * @param int $post_id
     * @param string $date_comment
     * @param string $content
     * @param int $status
     */
    public function __construct(int $id, int $users_id, int $post_id, string $date_comment, string $content, int $status)
    {
        $this->id = $id;
        $this->users_id = $users_id;
        $this->post_id = $post_id;
        $this->date_comment = $date_comment;
        $this->content = $content;
        $this->status = $status;
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

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


    public static function getByPostId($post_id) : array
    {
        self::connect();
        $results = self::query("SELECT * FROM `comments` WHERE `post_id` = :post_id AND `status` = 1", ['post_id' => $post_id]);

        $comments = [];

        foreach($results AS $result)
        {
            $comment = new Comment($result['id'], $result['users_id'], $result['post_id'], $result['date_comment'], $result['content'], $result['status']);
            $comments[] = $comment;
        }
        return $comments;

    }

    public static function create(int $post_id, int $users_id, string $content)
    {
        self::connect();

        self::execute("INSERT INTO `comments`(`post_id`, `users_id`, `date_comment`, `content`, `status`) 
                        VALUES (:post_id, :users_id, :date_comment, :content, :status)",
                        ['post_id' => $post_id, 'users_id' => $users_id, 'date_comment' => date("Y-m-d H:i:s"),
                        'content' => $content, 'status' => 0 ]);
    }

    public static function getNotValidated() : array
    {
        self::connect();

        $results = self::query("SELECT * FROM comments WHERE status = 0", []);

        $comments = [];

        foreach($results AS $result)
        {
            $comment = new Comment($result['id'],
                                    $result['users_id'],
                                    $result['post_id'],
                                    $result['date_comment'],
                                    $result['content'],
                                    $result['status']);
            $comments[] = $comment;
        }
        return $comments;
    }

    public static function validate(int $id)
    {
        self::connect();

        self::query("UPDATE comments SET status = 1 WHERE id = :id", ['id' => $id]);
    }

    public static function delete(int $id)
    {
        self::connect();

        self::query("DELETE FROM comments WHERE id = :id", ['id' => $id ]);
    }


}