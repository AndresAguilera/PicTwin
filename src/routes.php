<?php
// Routes

use Illuminate\Support\Facades\DB;


$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

class Order extends Illuminate\Database\Eloquent\Model {

    protected $fillable = ['title','testCol'];
    public $timestamps = false; //eliminar autoincremento
}

class Picture extends Illuminate\Database\Eloquent\Model {
    public $table = "picture";
    protected $fillable = ['id','idDevice','latitude','longitude','positives','negatives','warnings','file','date'];
    public $timestamps = false; //eliminar autoincremento
}
class Twin extends Illuminate\Database\Eloquent\Model {
    public $table = "twin";
    protected $fillable = ['idDevice','id1','id2'];
    public $timestamps = false; //eliminar autoincremento
}

$app->get('/json/test', function ($request, $response, $args) {
    /*
    $order = new Picture();
    //$order = Order::first();
    $order->title = "Titulo de la orden";
    $order->testCol = "testing";
    $order->save();

    $data = array(
        'pictures'=> array(
            Picture::All()->toArray()
        )
    );
*/


    //INSERTS
/*
    $cant = 0;
    $dir = 'pics/';
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false) {
            if (!in_array($file, array('.', '..')) && !is_dir($dir . $file)){
                echo $file;
                $cant++;
                $pic = new Picture();
                $pic->idDevice = $cant;
                $pic->latitude = $cant;
                $pic->longitude = $cant;
                $pic->file = $file;

                $twin = new Twin();
                $twin->idDevice = $cant;
                $twin->id1 = 1;
                $twin->id2 = $cant;

                $pic->save();
                $twin->save();
            }
        }
    }
    // prints out how many were in the directory
    echo "There were $cant files";
*/
    //echo json_encode($data);
    return $response->withJson(Picture::All()->toArray());

    //return $response->withJson(Picture::all()->toArray());
});

/*
 * Retorna el la imagen correspondiente a la ID seleccionada
 */
$app->get('/json/getPic', function ($request, $response, $args) {

  $connection = mysqli_connect('localhost','root','','twinpic');

        $query = "
SELECT picture.*
FROM twin, picture
WHERE twin.id2 = picture.id
GROUP BY picture.id
HAVING count(picture.id) = (
  SELECT count(picture.id) AS asd
  FROM twin, picture
  WHERE twin.id2 = picture.id
  GROUP BY picture.id
  ORDER BY asd
  LIMIT 1)
LIMIT 1;";

    $result = $connection->query($query);
    $row = $result->fetch_assoc();

    // Codificando imagen a base64
    $array = array(
        'img' => "",
        'id' => $row['id'],
        'file' => $row['file'],
        'idDevice' => $row['idDevice'],
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude'],
        'positives' => $row['positives'],
        'negatives' => $row['negatives'],
        'warnings' => $row['warnings'],
        'date' => $row['date']
    );
    $path = 'pics/' . $array['file'];
    $data = file_get_contents($path);
    $encoded_image = base64_encode($data);
    $array['img'] = $encoded_image;
    $json = json_encode($array);

    mysqli_close($connection);
    return $json;
    //return $response->withJson($array);


});
// Muestra una pic segun su id
$app->get('/pic/[{id}]', function ($request, $response, $args) {

    $pic = Picture::find($args['id']);
    $file =  "/pics/" . $pic ->file;
    //echo '<img src= "' .$file. '" /><br />';

    return $response->withJson($file);

    //return $this->renderer->render($response, 'index.phtml', $args);

});

$app->get('/json/asd', function ($request, $response, $args) {
    $array = array('file' => "carita.png", 'path' => "carita.png");
    $path = 'pics/' . $array['path'];
    $data = file_get_contents($path);
    $code = base64_encode($data);
    $array['file'] = $code;
    $json = json_encode($array);
    return $json;
});

// Recibe una imagen y la guarda en el servidor
$app->post('/json/postpic', function ($request, $response, $args) {
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        $pic = $data['file'];
        $deviceId = $data['deviceId'];
        $date = $data['date'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $twinId = $data['id'];
        $img = base64_decode($pic);


        //crear nueva imagen en /pics/
        $fileName = $deviceId.$date;
        $path = 'pics/'.$fileName.".png";
        $file = fopen($path,'wb');
        $is_written = fwrite($file, $img);
        fclose($file);

        //Insertar nueva imagen en la base de datos
        $connection = mysqli_connect('localhost','root','','twinpic');

        $query = "SELECT picture.id FROM picture ORDER BY id DESC LIMIT 1";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        $id = $row['id'];

        //test: guardar pic que viene, parearla con una del server

        $picture = new Picture();
        $picture->idDevice = $deviceId;
        $picture->latitude = $latitude;
        $picture->longitude = $longitude;
        $picture->positives = 0;
        $picture->negatives = 0;
        $picture->warnings = 0;
        $picture->date = $date;
        $picture->file = $fileName;
        $picture->save();

        $twin = new Twin();
        $twin->idDevice = $deviceId;
        $twin->id1 = $id;
        $twin->id2 = $twinId;
        $twin->save();


        mysqli_close($connection);

    //}
    //return $response->withJson($json);
});