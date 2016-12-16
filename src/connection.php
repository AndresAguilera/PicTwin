<?php
/**
 * Created by PhpStorm.
 * User: Andrés
 * Date: 10-12-2016
 * Time: 20:41
 */

header('Content-type : bitmap; charset=utf-8');

if(isset($_POST["encoded_string"])){

    $encoded_string = $_POST["encoded_String"];
    $image_id = $_POST["id"];

    $decoded_string = base64_decode($encoded_string);
    $path = '/pics/'.$image_id;
    $file = fopen($path,'wb');
    $is_written = fwrite($file, $decoded_string);
    fclose($file);

    if($is_written > 0){
        $connection = mysqli_connect('localhost','root','','twinpic');
        $query = "INSERT INTO picture(file, idDevice) values('$encoded_string','$image_id')";
        $result = mysqli_query($connection,$query);

        if($result){
            echo "success";
        }else{
            echo "failed";
        }
        mysqli_close($connection);
    }
}