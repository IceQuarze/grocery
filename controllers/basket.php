<?php
    class Basket extends CI_Controller{
        public function index(){
            if(count($_POST)){
                $command=$_POST["command"];
                $user=$_POST["user"];
                $passwd=$_POST["passwd"];
                $pdo=new PDO("mysql:host=localhost;dbname=grocery","root","root");
                $data=$pdo->query("select * from account where user='".$user."' and passwd='".$passwd."'")->fetch();
                if(!($data[0]==$user&&$data[1]==$passwd)){
                    echo "0";
                    exit();
                }
                if($command=="additem"){
                    $class=$_POST["class"];
                    $id=$_POST["id"];
                    $pdo->exec("insert into ".$user." (class,id,id2)values('".
                                    $class."','".$id."','".md5($id.time())."')");
                    echo "1";
                }else if($command=="getitems"){
                    $data=$pdo->query("select * from ".$user)->fetchall();
                    $items=array();
                    foreach($data as $item){
                        $t=$pdo->query("select * from ".$item[0]." where id='".$item[1]."'")->fetch();
                        $t["id"]=$item[2];
                        $items[]=$t;
                    }
                    echo json_encode($items);
                }else if($command=="delitem"){
                    $id=$_POST["id"];
                    $pdo->exec("delete from ".$user." where id2='".$id."'");
                    echo "0";
                }
            }else{
                $this->load->view("basket.html");
            }
        }
    }
?>