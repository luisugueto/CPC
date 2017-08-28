<?php
    include("includes/functions.php");
    require("models/GalleryDoctors.php");
    require_once("PHPMailer/class.phpmailer.php");
    require_once '../google-api/src/Google/autoload.php';

    session_start();

    $gallery = new GalleryDoctors();

    if (isset($_FILES["file"]))
    {
        $file = $_FILES["file"];
        $code = generarCodigo(9);
        $nombre = $code.$file["name"];
        $tipo = $file["type"];

        $ruta_provisional = $file["tmp_name"];
        $carpeta = "img/doctors/galleries/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif')
        {
          exit();
        }
        else
        {
            $src = $carpeta.$nombre;
            if(move_uploaded_file($ruta_provisional, $src))
            {
                $gallery->setDoctorId($_POST['DoctorId']);
                $gallery->setLocation($nombre);
                $gallery->setType('Image');
                $gallery->CreateGalleryDoctor();
                echo "exito";
            }
            else
            {
                echo "fallo";
            }
        }
    }

    if(!isset($_POST['action']))
    {
        $_POST['action'] = '';
    }
    if(isset($_POST['id']))
    {
        $id = $_POST['id'];
    }
    elseif(isset($_POST['DoctorId']))
    {
        $id = $_POST['DoctorId'];
    }
    else
    {
        $id = '0';
    }


    if($id != '')
    {
        switch ($_POST['action'])
        {
            case 'submit':
                if(isset($_FILES["videoName"])){
                    $videoName = $_FILES["videoName"]["tmp_name"];
                    $videoTitle = $_POST["videoTitle"];
                    $videoInfo = $_POST["videoInfo"];
                    $videoTags = explode(",", $_POST["videoTags"]);

                    $OAUTH2_CLIENT_ID = '411055274937-p4qa318es9r8smcdte190i7nmfflqdfc.apps.googleusercontent.com';
                    $OAUTH2_CLIENT_SECRET = 'sDyrjrrqdcLhXzXBuOfZy0ye';

                    $client = new Google_Client();
                    $client->setClientId($OAUTH2_CLIENT_ID);
                    $client->setClientSecret($OAUTH2_CLIENT_SECRET);
                    $client->setScopes('https://www.googleapis.com/auth/youtube');

                    $redirect = filter_var('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);

                    $client->setRedirectUri($redirect);

                    $youtube = new Google_Service_YouTube($client);

                    if (isset($_GET['code']))
                    {
                        if (strval($_SESSION['state']) !== strval($_GET['state']))
                        {
                            var_dump($_SESSION['state']);
                            var_dump($_GET['state']);
                                die('El estado de la sesión ha vencido.');
                        }
                        $client->authenticate($_GET['code']);
                        $_SESSION['token'] = $client->getAccessToken();
                        header('Location: ' . $redirect);
                    }

                    if (isset($_SESSION['token']))
                    {
                        $client->setAccessToken($_SESSION['token']);
                    }

                    if ($client->getAccessToken())
                    {
                        try
                        {
                            $videoPath = $videoName;

                            $snippet = new Google_Service_YouTube_VideoSnippet();
                            $snippet->setTitle($videoTitle);
                            $snippet->setDescription($videoInfo);
                            $snippet->setTags($videoTags);

                            //Categorías: https://developers.google.com/youtube/v3/docs/videoCategories/list
                            $snippet->setCategoryId("22");

                            // Estados: 'public', 'private' y 'unlisted'.
                            $status = new Google_Service_YouTube_VideoStatus();
                            $status->privacyStatus = "public";

                            $video = new Google_Service_YouTube_Video();
                            $video->setSnippet($snippet);
                            $video->setStatus($status);

                            $chunkSizeBytes = 1 * 1024 * 1024;

                            $client->setDefer(true);

                            $insertRequest = $youtube->videos->insert("status,snippet", $video);

                            $media = new Google_Http_MediaFileUpload(
                                $client,
                                $insertRequest,
                                'video/*',
                                null,
                                true,
                                $chunkSizeBytes
                            );

                            $media->setFileSize(filesize($videoPath));

                            $status = false;
                            $handle = fopen($videoPath, "rb");

                            while (!$status && !feof($handle))
                            {
                                $chunk = fread($handle, $chunkSizeBytes);
                                $status = $media->nextChunk($chunk);
                            }

                            fclose($handle);

                            $client->setDefer(false);

                            // ID del video:
                            $gallery->setDoctorId($_POST['DoctorId']);
                            $gallery->setLocation($status['id']);
                            $gallery->setType('Video');
                            $gallery->CreateGalleryDoctor();
                            // echo $status['id'];
                            // Guardar en la BD el ID del video.

                            echo "exito";
                        }
                        catch (Google_ServiceException $e)
                        {
                            echo json_encode("Ha ocurrido un error del servicio");
                        }
                        catch (Google_Exception $e)
                        {
                            echo json_encode("Ha ocurrido un error del cliente");
                        }

                        $_SESSION['token'] = $client->getAccessToken();
                        exit();
                    }
                    else
                    {
                        $state = mt_rand();
                        $client->setState($state);
                        $_SESSION['state'] = $state;
                        $authUrl = $client->createAuthUrl();
                        echo json_encode("Se requiere autorización de YouTube");
                        exit();
                    }
                }
            break;
            case 'delete':
                if($id != '0')
                {
                    $gallery->setGalleryDoctorId($id);
                    $nameImg = $gallery->GetGalleryLocation($id);
                    $typeImg = $gallery->GetGalleryType($id);
                    echo json_encode($gallery->DeleteGalleryDoctor());
                    if($typeImg == 'Image'){
                        $gallery->deleteFile("img/doctors/galleries/".$nameImg);
                    }
                    exit();
                }
            break;
        }
    }
?>
<?php
    if($_POST['action'] == 'videos')
    {
?>

<script src="custom.js"></script>
<script src="functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2>Video</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" enctype="multipart/form-data" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="DoctorId" value="<?php echo $id ?>" />
                    <div class="form-group">
                        <label>
                            Título:
                        </label>
                        <input type="text" name="videoTitle" id="videoTitle" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>
                            Descripción:
                        </label>
                        <textarea name="videoInfo" id="videoInfo" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            Etiquetas:
                        </label>
                        <input type="text" name="videoTags" id="videoTags" class="form-control" required>
                        <small>Separar por comas ","</small>
                    </div>
                    <div class="form-group">
                        <label>
                            Seleccione video:
                        </label>
                        <input type="file" name="videoName" id="videoName" accept="video/*" required>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>

        <?php
            if($_POST['action'] == 'videos')
            {
        ?>
                <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitVideoModalForm('gallery');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
        <?php
            }
            else
            {
        ?>
                <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('gallery');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
        <?php
            }
        ?>


      </div>
    </div>
</div>
<?php } ?>
<?php
    if($_POST['action'] == 'images')
    {
?>

<script src="custom.js"></script>
<script src="functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2>Foto</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">

                <form class="form-horizontal group-border-dashed" action="#" id="uploadimage" enctype="multipart/form-data" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="type" value="image">
                    <input type="hidden" name="DoctorId" value="<?php echo $id ?>" />
                    <div class="form-group">
                                            <input type="file" name="file" id="file" accept="image/x-png,image/gif,image/jpeg" required>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button class="btn btn-default waves-effect waves-light" disabled="disabled" id="uploads" > <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>
<?php } ?>
