<?php

namespace Karl\Content;

/**
 * A class whith a few methods to access and update the database
 */
class Content
{
    private $table;
    private $db;

    public function __construct($db, $table = "content")
    {
        $db->connect();
        $this->db = $db;

        $this->table = $table;
    }

    /**
     * Shows everything in the database
     * @return object Object with the result from the db-query
     */
    public function showAll()
    {
        $sql = "SELECT * FROM $this->table;";
        $res = $this->db->executeFetchAll($sql);
        return $res;
    }

    public function showAllBlogPost()
    {
        $sql = 'SELECT *, SUBSTRING(data, 1, 200) AS data_short, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%dT%TZ") AS published_iso8601, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%d") AS published FROM content WHERE type="post" AND (deleted IS NULL OR deleted > NOW()) AND published <= NOW() ORDER BY published DESC ;';
        $res = $this->db->executeFetchAll($sql);
        return $res;        
    }

    public function showPost($search, $column)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = ? AND (deleted IS NULL OR deleted > NOW()) AND published <= NOW()";
        $res = $this->db->executeFetchAll($sql, [$search]);
        return $res;
    }

    public function showAllPages()
    {
        $sql = 'SELECT *, CASE WHEN (deleted <= NOW()) THEN "isDeleted" WHEN (published <= NOW()) THEN "isPublished" ELSE "notPublished" END AS status FROM content WHERE type=?;';

        $res = $this->db->executeFetchAll($sql, ["page"]);
        return $res;        
    }


    


    

    public function savePost($params)
    {
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        try {
            $this->db->execute($sql, array_values($params));
        } catch (\Anax\Database\Exception\Exception $e) {
            return $e;
        }   
    }

    public function deletePost($id)
    {
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->db->execute($sql, [$id]);
    }

    public function createPost($title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->db->execute($sql, [$title]);
    }

    /**
     * Get value from POST variable or return default value.
     *
     * @param mixed $key     to look for, or value array
     * @param mixed $default value to set if key does not exists
     *
     * @return mixed value from POST or the default value
     */
    public function getPost($app, $key, $default = null)
    {
        if (is_array($key)) {
            // $key = array_flip($key);
            // return array_replace($key, array_intersect_key($_POST, $key));
            foreach ($key as $val) {
                $post[$val] = $this->getPost($app, $val);
            }
            return $post;
        }

        return null != $app->request->getPost($key)
            ? $app->request->getPost($key)
            : $default;
    }

    public function resetDatabase($config)
    {
        // Restore the database to its original settings
        $file   = "../sql/content/setup.sql";
        $output = null;
        $dsnDetail = [];
        preg_match("/mysql:host=(.+);dbname=([^;.]+)/", $config["dsn"], $dsnDetail);
        $host = $dsnDetail[1];
        $database = $dsnDetail[2];
        $login = $config["username"];
        $password = $config["password"];



        if ($_SERVER["SERVER_NAME"] === "www.student.bth.se") {
            $mysql  = "/usr/bin/mysql";          
        } else {
            $mysql  = "/usr/local/mysql-8.0.19-macos10.15-x86_64/bin/mysql";
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
