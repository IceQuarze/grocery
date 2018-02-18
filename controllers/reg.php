<?php
    class Reg extends CI_Controller{
        public function index(){
            if(!count($_POST)){
                $this->load->view("reg.html");
            }else{
                $command=$_POST["command"];
                $pdo=new PDO("mysql:host=localhost;dbname=grocery","root","root");
                $user=$_POST["user"];
                $passwd=$_POST["passwd"];
                if($command=="reg"){
                    $data=$pdo->query("select * from account where user='".$user."'")->fetch();
                    if($data){
                        echo "0";
                        exit();
                    }
                    $pdo->exec("insert into account(user,passwd)values('"
                                    .$user."','".$passwd."')");
                    $pdo->exec("create table ".$user.
                                    "(class varchar(255),id varchar(255),id2 varchar(255))");
                    echo "1";
                }
            }
        }
    }