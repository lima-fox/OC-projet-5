<?php
namespace App;

Class Post extends \Database
{
    private int $id;
    private string $date;
    private ?string $date_modif;
    private string $title;
    private string $chapo;
    private string $content;
    private int $author;

    public function __construct(int $id, string $date, ?string $date_modif, string $title, string $chapo, string $content, int $author)
    {
        $this->id = $id;
        $this->date = $date;
        $this->date_modif = $date_modif;
        $this->title = $title;
        $this->chapo = $chapo;
        $this->content = $content;
        $this->author = $author;
        
    }

    // liste des getters
    public function getId() : int
    {
        return $this->id;
    }

    public function getDate() : string
    {
        return $this->date;
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

    //liste des setters
    public function setId(int $id)
    {
         $this->id = $id;
    }

    public function setDate(string $date)
    {
        $this->date = $date;
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

        $result = self::query('SELECT * ,DATE_FORMAT(`date`,"%d/%m/%Y à %Hh%imin%ss") AS date_post 
                                    FROM posts 
                                    WHERE id = :id', ['id' => $id])->fetch();
        if (is_array($result))
        {
            $post = new Post($result['id'], $result['date'], $result['date_modif'], $result['title'], $result['chapo'], $result['content'], $result['author']);
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
        $results = self::query('SELECT * ,DATE_FORMAT(`date`,"%d/%m/%Y à %Hh%imin%ss") AS date_post FROM posts ORDER BY `date` DESC');

        $posts = [];

        foreach($results AS $result)
        {
            $post = new Post($result['id'], $result['date'], $result['date_modif'], $result['title'], $result['chapo'], $result['content'], $result['author']);
            $posts[] = $post;
        }
        return $posts;


    }
    
}