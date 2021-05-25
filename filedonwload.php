<?php
include "db.php";

echo ("file donwload");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    /*$stat = $db->prepare("select * from newfiles where _id=?");
    $stat->bindParam(1, $id);
    $stat->execute();
    $data = $stat->fetch();
    $file = $filepath.'/'.$data['filename'];*/


    $sql = "select *
    from archivos where  _id =:_id";

    try{

        $db = new db();
        $db = $db->connectDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":_id", $id );

        $stmt->execute();
        $stmt->bindColumn(5, $mime); 
        $stmt->bindColumn(3, $data, PDO::PARAM_LOB);
        $stmt->bindColumn(4, $fname);
        $stmt->fetch(PDO::FETCH_BOUND);
    
    } catch(PDOException $e) {

    }
    
    
  
    header('Content-Description: File Transfer');
    header('Content-Type: application/download');
    header('Content-Transfer-Encoding: Binary');
    header('Content-Type: '.$mime);
    header('Content-disposition: attachment; filename="'.basename($fname).'"');

    header('Pragma: public');
    ob_clean(); flush();
   
    echo $data;
    exit;
    
}