<?php

require_once __DIR__ . '/../connection/connection.php';
if(!session_id())
    session_start();
class CrudOffer extends Basedonne {
    public function __construct()
    {
        $this->connection(); // Ensure the connection is established
    }
    public function insertionofers($title, $descrip, $entreprise, $local, $status, $image){
        $query1 = "INSERT INTO offreemploi (`TitreOffre` , `DescriptionOffre`, `Entreprise`, `Localisation`, `Statut`, `Image`) values ('$title', '$descrip', '$entreprise',' $local', '$status', '$image')";
        $result = mysqli_query($this->conn, $query1);
        if($result){
            return true;
        }else
        {
            return false;
        }
    }

    public function getalloffers(){
        $data = "select * from offreemploi";
        $result = mysqli_query($this->conn, $data);
        $table = [];
        while ($row = mysqli_fetch_assoc($result)){
            $table[] = $row;
        }
        return $table;
    }

    // get offers applying .
    public function offerapplying($iduser, $idoffer, $dateapplying){
        if($this->isUserAlreadyApplyToOffre($iduser, $idoffer)){
            echo "<script>alert('User Already Applied')</script>";
            return; // exit in the method immediately and return void
        }

        $query = "INSERT INTO `candidature`(`UserID`, `OffreID`, `DateSoumission`) VALUES ('$iduser','$idoffer','$dateapplying')";
        $rslt = mysqli_query($this->conn, $query);
        if($rslt){
            echo "<script>alert('request successfully')</script>";
        }
    }

    /**
     *  it checks if the user is already applied to an offer
     ** return 1 if the user already applied
     **        0 if not
     **/
    public function isUserAlreadyApplyToOffre($userId, $OffreId) {
        $query = "SELECT count(*) as size from `candidature` c where c.UserId = $userId AND OffreId = $OffreId";
        $rslt = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($rslt);
        return $row['size'];
    }

    public function searchOffersByKeyWords($searchText)
    {
        $data = "select * from offreemploi o where o.DescriptionOffre LIKE '%$searchText%' OR  o.TitreOffre LIKE '%$searchText%'";
        $result = mysqli_query($this->conn, $data);
        $table = [];
        while ($row = mysqli_fetch_assoc($result)){
            $table[] = $row;
        }
        return $table;
    }
}
if(isset($_POST['job_id'])){
    $iduser = $_SESSION['UserID'];
    $idoffer = $_POST['job_id'];
    $dateNow = date("Y-m-d H:i:s");
    $apply = new CrudOffer();
    $apply->offerapplying($iduser, $idoffer, $dateNow);
    header("location: ../index.php");
}
// insertion des offers
if(isset($_POST['Addoffer'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $enterprise = $_POST['enterprise'];
    $local = $_POST['local'];
    $status = $_POST['taskstatus'];
   $image = uploadimage();
    $func = new CrudOffer();
    $rsltfunc = $func->insertionofers($title, $description, $enterprise, $local, $status, $image);
    if ($rsltfunc){
     header("location: ../dashboard/dashboard.php");
    }else{
        echo "<script>alert('not save')</script>";
    }
}

if(isset($_GET['searchText'])) {
    $crudOffer = new CrudOffer();
    $offers = $crudOffer->searchOffersByKeyWords($_GET['searchText']);
    echo json_encode($offers);
}


function uploadimage()
{
    if (isset($_FILES['my_image']['name']))
    {
       /* echo "<pre>";
        print_r($_FILES['my_image']);
        echo "</pre>";
        die();*/

        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        if ($error === 0)
        {

            if ($img_size > 17000000)
            {
                echo "<pre>";
                print_r($_FILES['my_image']);
                echo "</pre>";
                die();
                $_SESSION['Error'] = "Sorry, your file is too large.";
                header('location: ../dashboard/dashboard.php');
            }
            else
            {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);// return extension of image
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");


                if (in_array($img_ex_lc, $allowed_exs))
                {

                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = '../dashboard/img/uploads/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                }
                else {
                    $_SESSION['Error'] = "You can't upload files of this type";
                    header('location:../dashboard/dashboard.php');
                }
            }
        }
        else
        {
            $_SESSION['Error'] = 'unknown error occurred!';
            header('location: ../dashboard/dashboard.php');

        }
    }
    return $new_img_name;
}