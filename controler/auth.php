<?php
require '../connection/connection.php';
session_start();
class Authentication extends Basedonne {
    public function login($email, $password){
        $query = "select * from `utilisateur` where '$email' = Email";
        $this->connection();
        $result = $this->conn->query($query);
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['MotDePasse']))
        {
             $_SESSION['UserID'] = $user['UserID'];
             $_SESSION['Role'] = $user['Role'];
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
            $query1 = "INSERT INTO utilisateur (`NomUtilisateur`, `MotDePasse`, `Email`, `Role`) VALUES ('$name', '$hash', '$email', 'admin')";
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
