<?php

namespace Karl\Movie;

/**
 * A class whith a few methods to access and update the database
 */
class Movie
{
    /**
     * @var value the value of the dice.
     */

    private $res;
    private $columns;
    private $table;
    private $app;

    public function __construct($app, array $columns = ["id", "title", "year", "image"], string $table = "movie")
    {
        $this->res = null;
        $this->columns = $columns;
        $this->table = $table;
        $this->app = $app;
    }

    /**
     * Shows everything in the database
     * @return object Object with the result from the db-query
     */
    public function showAll()
    {
        $db = $this->app->db;
        $db->connect();
        $sql = "SELECT * FROM $this->table;";
        $res = $db->executeFetchAll($sql);
        return $res;
    }

    /**
     * Fetches a specific movie in the database
     * @param int $id of the movie
     * @return object Object with the result from the db-query
     */
    public function showMovie($id)
    {
        $db = $this->app->db;
        $db->connect();
        $sql = "SELECT * FROM $this->table WHERE id = ?;";
        $res = $db->executeFetch($sql, [$id]);
        return $res;
    }

    /**
     * Fetches everything in the database ordered by your choice
     * @param string $orderBy column to order by, must be in $this->columns
     * @param string $order The order, must be desc or asc. asc is default.
     * @return object Object with the result from det db.query
     */
    public function showAllSort($orderBy, string $order = "asc")
    { 
        // Only these values are valid
        $columns = $this->columns;
        $orders = ["asc", "desc"];

        // Incoming matches valid value sets
        if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
            return "Not valid input for sorting.";
        }
        $this->app->db->connect();
        $sql = "SELECT * FROM $this->table ORDER BY $orderBy $order";
        $res = $this->app->db->executeFetchAll($sql);

        return $res;
    }

    /**
     * Fetches a number of hits in the database based on hits and page. Used to paginate
     * @param int $hits how many movies per page
     * @param int $page which page?
     * @param string $orderBy which column to order by
     * @param string $order wich order (asc or desc)
     * @return object Object with the result from the db-query
     */
    public function showAllPaginate(int $hits = 4, int $page = 1, $orderBy = "id", string $order = "asc")
    {
        $db = $this->app->db;
        $db->connect();
        // Get max number of pages
        $sql = "SELECT COUNT(id) AS max FROM movie;";
        $max = $db->executeFetchAll($sql);
        $max = ceil($max[0]->max / $hits);

        if (!(is_numeric($hits) && $page > 0 && $page <= $max)) {
            return "Not valid for page.";
        }
        $offset = $hits * ($page - 1);

        // Only these values are valid
        $columns = ["id", "title", "year", "image"];
        $orders = ["asc", "desc"];


        // Incoming matches valid value sets
        if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
            return "Not valid input for sorting.";
        }

        $sql = "SELECT * FROM movie ORDER BY $orderBy $order LIMIT $hits OFFSET $offset;";
        $res = $db->executeFetchAll($sql);
        return ["res" => $res, "max" => $max];
    }

    /**
     * Serches for something in get
     * @return object Object with the result from the db-query
     */
    public function search()
    {
        $title = $this->app->request->getGet("searchTitle");
        $year1 = $this->app->request->getGet("year1");
        $year2 = $this->app->request->getGet("year2");

        $db = $this->app->db;

        $db->connect();
        if ($title && $year1 && $year2) {
            $title = "%$title%";
            $sql = "SELECT * FROM movie WHERE title LIKE ? AND year >= ? AND year <= ?;";
            $res = $db->executeFetchAll($sql, [$title, $year1, $year2]);
            return $res;
        } elseif ($title) {
            $title = "%$title%";
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $db->executeFetchAll($sql, [$title]);
            return $res;
        } elseif ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $res = $db->executeFetchAll($sql, [$year1, $year2]);
            return $res;
        } else {
            return null;
        }
    }

    /**
     * Saves somthing i post
     * @return void
     */
    public function saveChanges()
    {
        $db = $this->app->db;
        $db->connect();

        $id = $this->app->request->getPost("movieId");
        $title = $this->app->request->getPost("movieTitle");
        $year = $this->app->request->getPost("movieYear");
        $image = $this->app->request->getPost("movieImage");

        if ($id == "new") {
            $sql = "INSERT INTO " . $this->table . " (title, year, image) VALUES (?, ?, ?);";
            $db->execute($sql, [$title, $year, $image]);
        } else { 
            $sql = "UPDATE " . $this->table . " SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$title, $year, $image, $id]);
        }
    }

    /**
     * Delets something in post
     * @return void
     */
    public function deleteMovie()
    {
        $db = $this->app->db;
        $db->connect();

        $id = $this->app->request->getPost("movieId");

        $sql = "DELETE FROM " . $this->table . " WHERE id = ?;";
        $db->execute($sql, [$id]);
    }

    /**
     * Resets the database
     * @return void
     */
    public function resetDatabase()
    {
        // Restore the database to its original settings
        $file   = "../sql/movie/setup.sql";
        $output = null;

        if ($_SERVER["SERVER_NAME"] === "www.student.bth.se") {
            $mysql  = "";          
            $host = "";
            $database = "";
            $login = "";
            $password = "";
        } else {
            $mysql  = "";          
            $host = "";
            $database = "";
            $login = "";
            $password = "";
        }       

        $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
        
        $output = [];
        $status = null;
        exec($command, $output, $status);
        $output = "<p>The command was: <code>$mysql -h{$host} -u[username]-p[password] $database < $file 2>&1</code>.<br>The command exit status was $status."
        . "<br>The output from the command was:</p><pre>"
        . print_r($output, 1);
        return $output;
    }
}
