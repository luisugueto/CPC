<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(5);
	$contentSection = $section->GetSectionContent();
 	include("includes/header.php");
	require_once("admin/models/GalleryDoctors.php");

	$gallery = new GalleryDoctors();

	function getYoutubeVideos($playlistID)
	{
		$list = $playlistID;
		$key = "AIzaSyBMKyjwq9euxN_XvJrehe8gN_ZbSKym-2A";
		$maxVideos = "8";

		if ($key && $list)
		{
			function get_data($url)
			{
				$ch = curl_init();
				$timeout = 5;
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json','Accept: application/json'));
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
				$data = curl_exec($ch);
				curl_close($ch);
				return $data;
			}

			$apiPlaylist = get_data("https://www.googleapis.com/youtube/v3/playlistItems?part=id,snippet,contentDetails,status&maxResults=".$maxVideos."&playlistId=".$list."&key=".$key."");
			$video = json_decode($apiPlaylist, true);

			$videolist = array();

			foreach ($video['items'] as $videoitem)
			{
				$videolist[] = $videoitem;
			}

			return $videolist;
		}
		return false;
	}

	$youtubePlaylist = 'PL8w22-oxVtL3pOufp79RnicYrB23qxzc4'; //https://www.youtube.com/watch?v=3ZwAi2M8lgs&list=PLmPrLwZhMrsyQJeD3mnbyMk5iRm1qUia1
	$feedYoutube = getYoutubeVideos($youtubePlaylist);
	$i = 0;
	if ($feedYoutube != "")
	{
		foreach($feedYoutube as $item)
		{
			if(isset($item["snippet"]["thumbnails"]["high"]['url']) && $item["snippet"]["thumbnails"]["high"]['url'] != "")
			{
				$youtube[$i]['title'] = $item["snippet"]["title"];
				$youtube[$i]['image'] = $item["snippet"]["thumbnails"]["high"]['url'];
				$youtube[$i]['url'] = $item["contentDetails"]["videoId"];
				$youtube[$i]['tags'] = $item["snippet"]["title"];
				$youtube[$i]['description'] = $item["snippet"]["description"];
				$i++;
			}
		}
	}
?>

	<!-- Contenido -->
	<div class="container">
		<div class="row">

			<!-- columna izquierda -->
			<div class="col m9 s12">

                <?php
                    $videoId = explode(".", $_GET['id']);

                    foreach($youtube as $item)
					{
                        if ($item['url'] == $videoId[0])
                        {
                ?>
                            <section class="hide-on-small-only">
                                <!-- Título -->
                                <div class="title-divider">
                                    <h1><?= $item["title"] ?></h1>
                                </div>
                                <!-- Fin título -->
                            </section>

                            <!-- video -->
                            <div class="row">
                                <div class="col s12">
                                    <div class="card horizontal">
                                        <div class="card-stacked">
                                            <div class="card-content">
                                                <iframe width="100%" height="380" src="https://www.youtube.com/embed/<?= $item['url'] ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                                                <br><br>
                                                <p><?= $item["description"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin video -->
                <?php
                            break;
                        }
                    }
                ?>

			</div>
			<!-- fin columna izquierda -->

			<!-- side bar (columna derecha) -->
			<div class="col m3 s12 hide-on-small-only">
				<?php include("includes/sidebar.php"); ?>
			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>
