<?php
class User extends Dbh
{
    public function listUsers()
    {
        $stmt = $this->connect()->query("SELECT * FROM users;");
        while ($row = $stmt->fetch())
        {
            $name = $row['name'];
            echo("<a href=\"".$name."\">".$name."</a>");
            echo("<br>");
        }
        return 0;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users;";
        $stmt = $this->connect()->query($sql);
        $users = $stmt->fetchAll();
        return $users;
    }

    public function getAllUserNames()
    {
        $sql = "SELECT name FROM users;";
        $stmt = $this->connect()->query($sql);
        $userNames = $stmt->fetchAll(PDO::FETCH_COLUMN,0);
        return $userNames;
    }

    public function getUserName($id)
    {
        $stmt = $this->connect()->query("SELECT name FROM users
                                         WHERE idUsers = ".$id.";");
        return $stmt->fetch()['name'];
    }

    public function getUserID($name)
    {
        $sql = "SELECT idUsers FROM users
                WHERE name = '".$name."';";
        $stmt = $this->connect()->query($sql);
        $id = $stmt->fetchAll(PDO::FETCH_COLUMN,0);
        return $id;
    }

    public function addUser($name, $about)
    {
        $id = 0;
        $stmt = $this->connect()->query("SELECT count(idUsers) c FROM users;");
        $id = $stmt->fetch()['c'];
        $sql = "INSERT INTO users (idUsers, name, bib)
                VALUES('".$id."','".$name."', '".$about."');";
        try
        {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return 0;
        }
        catch(PDOException $e)
        {
            echo($sql."<br>".$e->getMessage());
            return 1;
        }
    }
}
?>
