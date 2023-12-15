<?php
require '../connection/connection.php';
session_start();
class Authentication extends Basedonne {


    public function __construct()
    {
        $this->connection(); // Ensure the connection is established

    }

    public function login($email, $password){
        $this->connection(); // Ensure the connection is established

        $query = "select * from `utilisateur` where '$email' = Email";
        $result = $this->conn->query($query); // execution requete.
        $user = $result->fetch_assoc(); // fetch data.
        if(password_verify($password, $user['MotDePasse']))
        {
             $_SESSION['UserID'] = $user['UserID'];
             $_SESSION['Role'] = $user['Role'];
             $_SESSION['name'] = $user['NomUtilisateur'];
             if($user['Role'] == "admin"){
                 header("location: ../dashboard/dashboard.php");
             }elseif ($user['Role'] == "condidat"){
                 header("location: ../index.php");
             }else{
                 echo " doesn't find u";
             }
        }else
        {
            header("location: ../login.php");
        }
    }

    public function register($name, $email, $password, $confirmpwd) {
        $this->connection(); // Ensure the connection is established

        if ($password == $confirmpwd) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query1 = "INSERT INTO utilisateur (`NomUtilisateur`, `MotDePasse`, `Email`, `Role`) VALUES ('$name', '$hash', '$email', 'condidat')";
            $res = mysqli_query($this->conn, $query1);

            if ($res) {
                header("location: ../login.php");
            } else {
                header("location: ../register.php");
            }
        } else {
            header("location: ../register.php");
        }
    }

    public function updateprofele(){
        $this->connection(); // Ensure the connection is established

            $UserID = $_SESSION['UserID'];
            $name = $_POST['name'];
            $update = "UPDATE utilisateur  SET NomUtilisateur='$name' WHERE UserID = '$UserID'";
            $res = mysqli_query($this->conn, $update);
            if($res){
                $_SESSION['name'] = $name;
                header('location: profile.php');
            }else{
                echo "<script> alert('doesn\'t exist') </script>";
            }

    }
    public  function deleteaccount(){
        $this->connection();

            $UserID = $_SESSION['UserID'];
            $delete = "DELETE FROM `utilisateur` WHERE UserID = '$UserID'";
            $result = mysqli_query($this->conn, $delete);
            if($result){
                session_unset();
                session_destroy();
                header("location: ../index.php");
            }
        }

}

$auth = new Authentication();

if (isset($_POST['register'])) {
    $auth->register($_POST["name"], $_POST["email"], $_POST["password"], $_POST["confirmepassword"]);
}

if(isset($_POST['login'])){
    $_email = $_POST['email'];
    $_pwd = $_POST['password'];
    $auth->login($_email, $_pwd);
}

if(isset($_POST['updateProfile'])){
    $auth->updateprofele();
}
if (isset($_POST['deleteAccount'])){
    $auth->deleteaccount();
}

