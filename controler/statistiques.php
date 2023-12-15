<?php
require '../connection/connection.php';
class Statistiques extends Basedonne {
    public function __construct()
    {
        $this->connection(); // Ensure the connection is established
    }
   public function countOffer(){
       $this->connection();
       $countoffer = "SELECT count(*) as number_offer FROM `offreemploi` ";
       $result = $this->conn->query($countoffer);
       $row = mysqli_fetch_assoc($result);
       return $row['number_offer'];
    }
    public function countOfferactif(){
        $this->connection();
        $actifoffer = "SELECT count(*) as actifoffres FROM `offreemploi` where visibilite = 'actif';";
        $result = $this->conn->query($actifoffer);
        $row = mysqli_fetch_assoc($result);
        return $row['actifoffres'];
    }
}

