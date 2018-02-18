<?php
    class Admin extends CI_Controller{
        public function index(){
            if(count($_POST)==0){
                return $this->load->view("admin.html");
            }else{
                $command=$_POST["command"];
                $pdo=new PDO("mysql:host=localhost;dbname=grocery","root","root");
                if($command=="getclass"){
                    echo json_encode($pdo->query("select * from all_classes")->fetchall());
                //    echo "[{\"a\":\"b\"}]";
                }else if($command=="addclass"){
                    $name=$_POST["name"];
                    $pdo->exec("create table ".$name.
                                " (id varchar(255),name varchar(255),detail text,price varchar(255))");
                    $pdo->exec("insert into all_classes (name,size)values('".$name."',0)");
                    echo "0";
                }else if($command=="delclass"){
                //    fclose(fopen("D:\\".$_POST["name"],"w"));
                    $name=$_POST["name"];
                    $pdo->exec("delete from all_classes where name='".$name."'");
                    $pdo->exec("drop table ".$name);
                    echo "0";
                }else if($command=="additem"){
                    $class=$_POST["class"];
                    $name=$_POST["name"];
                    $detail=$_POST["detail"];
                    $price=$_POST["price"];
                    $ans=$pdo->query("select size from all_classes where name='".
                                        $class."'")->fetch();
                    $size=$ans[0];
                    $size=(string)((int)$size+1);
                    fopen("D:\\".$class,"w");
                    $pdo->exec("update all_classes set size=".$size." where name='".$class."'");
                    $pdo->exec("insert into ".$class."(id,name,detail,price)values('"
                                .md5((string)(time()).$name)."','".$name.
                                "','".$detail."','".$price."')");
                    echo "0";
                }else if($command=="moditem"){
                    $class=$_POST["class"];
                    $id=$_POST["id"];
                    $name=$_POST["name"];
                    $detail=$_POST["detail"];
                    $price=$_POST["price"];
                    $pdo->exec("update ".$class." set name='".$name."' where id='".$id."'");
                    $pdo->exec("update ".$class." set detail='".$detail."' where id='".$id."'");
                    $pdo->exec("update ".$class." set price='".$price."' where id='".$id."'");

                    echo "1";

                }else if($command=="getitemsize"){
                    $class=$_POST["class"];
                    $ans=$pdo->query("select size from all_classes where name='".
                                        $class."'")->fetch();
                    $size=$ans[0];
                    echo json_encode($size);
                }else if($command=="getitems"){
                    $class=$_POST["class"];
                    echo json_encode(array_reverse($pdo->query("select * from ".$class)->fetchall()));
                }else if($command=="delitem"){
                    $class=$_POST["class"];
                    $id=$_POST["id"];
                    $pdo->exec("delete from ".$class." where id='".$id."'");
                    echo "1";
                }else if($command=="search"){
                    $class=$_POST["class"];
                    $name=$_POST["name"];
                    $data=$pdo->query("select * from ".$class." where name='".$name."'")->fetchall();
                    echo json_encode($data);
                }
            }
        }
    }
?>