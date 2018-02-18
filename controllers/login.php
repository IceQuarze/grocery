<?php
    class Login extends CI_Controller{
        public function index(){
            $user=$_POST["user"];
            $passwd=$_POST["passwd"];
            $pdo=new PDO("mysql:host=localhost;dbname=grocery","root","root");
            $data=$pdo->query("select * from account where user='".$user."' and passwd='".$passwd."'")->fetch();
            if($data){
                echo "1";
            }else{
                echo "0";
            }
        }
    }