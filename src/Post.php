<?php
namespace App;

Class Post extends \Database
{
    private int $id;
    private string $date_post;
    private ?string $date_modif;
    private string $title;
    private string $chapo;
    private string $content;
    private int $author;
    private ?User $user;

    public function __construct(int $id, string $date_post, ?string $date_modif, string $title, string $chapo, string $content, int $author)
    {
        $this->id = $id;
        $this->date_post = $date_post;
        $this->date_modif = $date_modif;
        $this->title = $title;
        $this->chapo = $chapo;
        $this->content = $content;
        $this->author = $author;
        $this->user = User::getById($author);
        
    }

    // liste des getters
    public function getId() : int
    {
        return $this->id;
    }

    public function getDatePost() : string
    {
        return $this->date_post;
    }

    public function getDate_modif() : ?string
    {
        return $this->date_modif;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getUpperTitle() : string
    {
        return strtoupper($this->getTitle());
    }

    public function getChapo() : string
    {
        return $this->chapo;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function getAuthor() : int
    {
        return $this->author;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }



    //liste des setters
    public function setId(int $id)
    {
         $this->id = $id;
    }

    public function setDatePost(string $date_post)
    {
        $this->date_post = $date_post;
    }

    public function setDateModif(?string $date_modif)
    {
        $this->date_modif = $date_modif;
    }

    public function setTitle(string $title)
    {
        $this->title = substr($title, 0, 255);
    }

    public function setChapo(string $chapo)
    {
            $this->chapo = substr($chapo, 0, 512);
    }

    public function setContent(string $content)
    {
            $this->content = $content;
    }

    public function setAuthor(int $author)
    {
            $this->author = $author;
    }

    public static function getById(int $id) : ?Post
    {
        self::connect();

        $result = self::query('SELECT * ,DATE_FORMAT(`date_post`,"%d/%m/%Y à %Hh%imin%ss") AS date_post 
                                    FROM posts 
                                    WHERE id = :id', ['id' => $id])->fetch();
        if (is_array($result))
        {
            $post = new Post($result['id'], $result['date_post'], $result['date_modif'], $result['title'], $result['chapo'], $result['content'], $result['author']);
            return $post;
        }
        else
        {
            return null;
        }

    }

    public static function getAll() : array
    {
        self::connect();
        $results = self::query('SELECT * ,DATE_FORMAT(`date_post`,"%d/%m/%Y à %Hh%imin%ss") AS date_post FROM posts ORDER BY `date_post` DESC');

        $posts = [];

        foreach($results AS $result)
        {
            $post = new Post($result['id'], $result['date_post'], $result['date_modif'], $result['title'], $result['chapo'], $result['content'], $result['author']);
            $posts[] = $post;
        }
        return $posts;


    }

    public static function create(string $title, string $chapo, string $content, string $author)
    {
        self::connect();

        self::execute("INSERT INTO `posts`(`date_post`, `title`, `chapo`, `content`, `author`) 
                            VALUES (:date_post, :title, :chapo, :content, :author)",
                            ['date_post' => date("Y-m-d H:i:s"),
                                'title' => $title,
                                'chapo' => $chapo,
                                'content' => $content,
                                'author' => $author]);
    }
    
}