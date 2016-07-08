<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscador con php</title>
        <script type="text/javascript" src="jquery.min.js"></script>
        
         <style>
            body{
                text-align: center;
            }
            
            section{
                margin: auto;
                text-align: center;
            }
            input{
                padding: 1%;
            }
            button{
                background: white;
                border: solid 1px black;
                padding: 1%;
            }
            button:hover{
                border: solid 1px cornflowerblue;
            }
            #datos{
                margin: 5px auto;
                width: 80%;
                padding: 1%;
                /*text-align: left;*/
            }
            
        </style>
    </head>
    <body>
        
        <h1>Buscador de Juegos</h1>
        <section>
            <form >
                <input id="nombre" name='nombre' placeholder="nombre del juego" autofocus required>
                <button id="buscar" type="submit">Buscar</button>
            </form>
            
        </section>
            <?php
               
        
         if (isset($_REQUEST["nombre"])){ 
            $api_key = '6ce1b9ca1ccfd4c2d49577c0e8c9278b1b3dbcb0';
            
            $nombre=$_REQUEST["nombre"];
            $palabra = explode(' ', $nombre);
            
            $conexion= mysqli_connect('localhost', 'comprobacion', 'comprueba', 'prueb'); 
                if($conexion) {
                    $sql="INSERT INTO `busquedas` (`nombre_busqueda`) VALUES
                    ('$nombre');";
                    mysqli_query($conexion, $sql);
                    mysqli_close($conexion);
                }else{
                    echo '<br>Error de conexion</br>';
                }
            
            
            for($j=0;$j<count($palabra);$j++){
                $query = $palabra[$j];
                $url = 'http://www.giantbomb.com/api/search/?api_key='.$api_key.'&format=json&query='.$query.'&resources=game';
                buscar($url);
            }
        }
        
        function buscar($url){
            
            $fichero_url = fopen ($url, "r");
            $contenido = "";
            while ($datos = fgets($fichero_url, 1024)){
               $contenido .= $datos;
            }
            $contenido = strip_tags($contenido);//quitar etiquetas html

            $datos_json = json_decode($contenido);
   
            $cantidad_juegos = count($datos_json->results);
            echo '<dl>';
            for ($i=0; $i<$cantidad_juegos; $i++){
                echo '<br>';
                echo '<dt>'.$datos_json->results[$i]->name.'</dt>';
                echo '<dd>'.$datos_json->results[$i]->description.'</dd>';
             }
             echo '</dl>';
        }
        
         
        
        
        
            ?>
    </body>
</html>

