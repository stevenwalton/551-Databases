<?php
include_once 'countryFunctions.php';

class State extends Dbh
{
    public function listStates()
    {
        $stmt = $this->connect()->query("SELECT * FROM State;");
        while ($row = $stmt->fetch())
        {
            $name = $row['name'];
            echo("<a href=\"".$name."\">".$name."</a>");
            echo("<br>");
        }
        return 0;
    }

    public function getStateID($name)
    {
        $stmt = $this->connect()->query("SELECT * FROM State;");
        while ($row = $stmt->fetch())
        {
            if($name == $row['name'])
            {
                return $row['idState'];
            }
        }
        // TODO:
        // Do we add a state if it doesn't exist?
    }

    public function getStateName($id)
    {
        $stmt = $this->connect()->query("SELECT name FROM State
                                         WHERE idState = ".$id.";");
        return $stmt->fetch()['name'];
    }

    public function addState($name,$country)
    {
        $id = 0;
        # Check if country exists
        $cnt = new Country;
        $idCountry = $cnt->getCountryID($country);
        echo("CountryID: ".$idCountry."<br>");
        $stmt = $this->connect()->query("SELECT * FROM State;");
        if(!(in_array($name,$stmt->fetch(),true)))
        {
            $stmt = $this->connect()->query("SELECT * FROM State;");
            while ($row = $stmt->fetch())
            {
                if($id == $row['idState'])
                {
                    $id++;
                }
            }
            echo("Adding state ".$name." with country ID ".$idCountry." and state id ".$id);
            # UNCOMMENT WHEN NOT TESTING
            #$inst = $this->connect()->query("INSERT INTO State (idState, idCountry, name) VALUES ('".$id."','".$idCountry."','".$name."');");
            return array("id"=>$id, "country"=>$idCountry, "name"=>$name); 
        }

    }
}
?>