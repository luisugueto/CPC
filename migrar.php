<?php
    $fichero = file_get_contents('file:///Users/wsandoval/Downloads/do3op_posts.json');
    $json = json_decode($fichero);
    require_once("admin/models/Articles.php");

    $articles = new Articles();

    $data = $json[2]->data;

    foreach ($data as $post)
    {
        if ($post->post_type == 'post' && $post->post_status == 'publish' && $post->post_parent == 0)
        {
            $articles->setTitle($post->post_title);

            $photo_name = "";

            foreach ($data as $postInfo)
            {
                if ($postInfo->post_type == 'attachment' && $postInfo->post_title == $post->post_title || $postInfo->post_type == 'attachment' && $postInfo->post_content == $post->post_title)
                {
                    //Get the file
                    $content = file_get_contents($postInfo->guid);

                    $photo_explode = explode("/", $postInfo->guid);
                    $photo_name = end($photo_explode);

                    //Store in the filesystem.
                    $fp = fopen("images/blog/".$photo_name, "w");
                    fwrite($fp, $content);
                    fclose($fp);

                    $articles->setPhoto($photo_name);
                }
            }

            if ($photo_name == "")
            {
                $domDocument = new DOMDocument();
                libxml_use_internal_errors(TRUE);

                $uri = 'http://www.cirugiaplasticacolombia.com/'.$post->post_name;

                $html = file_get_contents($uri);

                //Cargar contenido HTML
                $domDocument->loadHTML($html);
                libxml_clear_errors();
                
                //Instanciar clase DOMXPath para el HTML extráido.
                $dom_xpath = new DOMXPath($domDocument);

                //Tomar div con clase 'aviso'
                $imagen = $dom_xpath->query('//div[@class="image"]');

                if ($imagen->length > 0)
                {
                    foreach ($imagen as $img)
                    {
                        $link = $dom_xpath->query('//a[@class="overlay mgp-img"]', $img);
                        $img_url = $link->item(0)->getAttribute("href");

                        $content = file_get_contents($img_url);
                        
                        $photo_explode = explode("/", $img_url);
                        $photo_name = end($photo_explode);

                        //Store in the filesystem.
                        $fp = fopen("images/blog/".$photo_name, "w");
                        fwrite($fp, $content);
                        fclose($fp);

                        $articles->setPhoto($photo_name);
                        break;
                    }
                }
            }

            $articles->setContent(addslashes($post->post_content));

            $explode_date = explode(" ", $post->post_date);
            $fecha = $explode_date[0];
            $explode_fecha = explode("-", $fecha);
            $anio = $explode_fecha[0];
            $mes = $explode_fecha[1];
            $dia = $explode_fecha[2];
            $fecha_final = $dia."/".$mes."/".$anio;

            $articles->setPublishDate($fecha_final);
            $articles->setStatusId(1);
            $articles->setAuthor('Cirugia Plástica Colombia');
            $articles->setSlug($post->post_name);
            $articles->setMetaTitle($post->post_title);
            $articles->setMetaDescription($post->post_title);
            $articles->setTags("");
            $articles->setAltPhotos($post->post_title);

            $articles->CreateArticle();
            
        }
    }
?>