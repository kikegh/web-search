
<?php
require '../vendor/autoload.php';
require_once 'autoloader.php';
require_once 'dbrelatedstuff.php';


use Goutte\Client;
$client = new Client();
$url = $_POST["url"];
//$url = 'http://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml';
//$feed = new SimplePie();
//$feed->set_feed_url($url);
//$feed->enable_cache();
//$feed->init();
//$feed->handle_content_type();
$buscarlink = select_url($url);
$resultados = $buscarlink;

$titulo = "";
$author = "";
$html_code = "";
$keywords = "";
$tamanio_pag = "";
$last_modified = "";


if($resultados[0] == "No se encontraron resultados"){
    $crawler = $client->request('GET', $url);

    try {
        $titulo = $crawler->filterXpath('//meta[@name="title"]')->attr('content');
        echo "Title: " . $titulo . '<br>'; 
    } catch (Exception $e) {
        echo 'Excepción capturada: no se encontró el título';
    }
    try {
        $author =  $crawler->filterXpath('//meta[@name="Author"]')->attr('content');
        echo "Author: " . $author . '<br>'; 
    } catch (Exception $e) {
        echo 'Excepción capturada: no se encontró el autor';
    }


    try {
        $keywords =  $crawler->filterXpath('//meta[@name="Keywords"]')->attr('content');
        echo "Keywords: ". $keywords . '<br>'; 
    } catch (Exception $e) {
        echo 'Excepción capturada: no se encontraron keywords';
    }
    /* $crawler->filter('Keywords')->each(function ($node) {
        echo "keywords: ".$node->text()."\n";
    }); */

    try {
        $last_modified = $crawler->filterXpath('//meta[@name="Last-Modified"]')->attr('content');
        //date("D M j G:i:s T Y")
        //$last_modified = date(d m Y)
        echo "Last modified date: ". $last_modified . "<br>";
        //Regresar aqui :)
    } catch (Exception $e) {
        echo 'Excepción capturada: no se encontro fecha';
    }


    /* $crawler->filter('date')->each(function ($node) {
        echo "Fecha: ".$node->text()."\n";
    }); */


    try {
        $body = $crawler->filter('body');
        $html_code = $body->text();
        //echo "Contenido" . $html_code . '<br>';
        $tamanio_pag = strlen($html_code);
        echo "Tamaño de Contenido" . $tamanio_pag; 
    } catch (Exception $e) {
        echo 'Excepción capturada: no hay contenido';
    }
    $insertar_datos = insert_data($titulo, $keywords, $author, $html_code, $last_modified, $url, $tamanio_pag);
    echo $insertar_datos;
}
else{ //Aqui pondremos cuando sí se encuentre la página
    //Vamos a verificar si la pagina tiene el mismo tamaño o ha cambiado
    $crawler = $client->request('GET', $url);
    try {
        $html_code = $crawler->html();
        //echo "Contenido" . $html_code . '<br>';
        $tamanio_pag = strlen($html_code);

        echo "Tamaño de Contenido" . $tamanio_pag; 
    } catch (Exception $e) {
        echo 'Excepción capturada: no hay contenido';
    }
    if(intval($resultados[0]) != intval($tamanio_pag)){ //Significa que la pag cambió
        echo "Este es el tamaño de la pagina:  ".$tamanio_pag. "Y este el es de resultado ".$resultados[0];
        $crawler->filter('title')->each(function ($node) {
            $titulo = $node->text();
        });
        /* $crawler->filter('meta[name = author]')->each(function ($node) {
            echo "Autor: ".$node->text()."\n";
        }); */
    
        try {
            $author =  $crawler->filterXpath('//meta[@name="Author"]')->attr('content');
            echo "Author: " . $author . '<br>'; 
        } catch (Exception $e) {
            echo 'Excepción capturada: no se encontró el autor';
        }
    
    
        try {
            $keywords =  $crawler->filterXpath('//meta[@name="Keywords"]')->attr('content');
            echo "Keywords: ". $keywords . '<br>'; 
        } catch (Exception $e) {
            echo 'Excepción capturada: no se encontraron keywords';
        }
        /* $crawler->filter('Keywords')->each(function ($node) {
            echo "keywords: ".$node->text()."\n";
        }); */
    
        try {
            $last_modified = $crawler->filterXpath('//meta[@name="Last-Modified"]')->attr('content');
            echo "Last modified date: ". $last_modified . "<br>";
            //Regresar aqui :)
        } catch (Exception $e) {
            echo 'Excepción capturada: no se encontro fecha';
        }

        $actualizar_datos = update_data($resultados[1], $titulo, $keywords, $author, $html_code, $last_modified, $url, $tamanio_pag);
        echo $actualizar_datos;
    }
}

?>