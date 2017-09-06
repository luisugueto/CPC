<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(5);
	$contentSection = $section->GetSectionContent();
 	include("includes/header.php");
	require_once("admin/models/GalleryDoctors.php");
	require_once("admin/models/Categories.php");
	require_once("admin/models/Doctors.php");

	$doctor = new Doctors();
	
	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($Doctor = $doctorss->fetch(PDO::FETCH_ASSOC)){
		$arrayDoctors[$Doctor['DoctorName']." -".$Doctor['SubTitle']. " - [Doctor] - ".$Doctor['DoctorId'].""] = null;
	}
	$jsonDoctors = json_encode($arrayDoctors);

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();

	$arrayProcedures = array();

	while($Procedures = $categoriesList->fetch(PDO::FETCH_ASSOC)){
		$arrayProcedures[$Procedures['Name']." - ".$Procedures['CategoryId']." - [Procedimiento]"] = null;
	}
	$jsonProcedures = json_encode($arrayProcedures);
	$arrayMerge = array_merge($arrayDoctors, $arrayProcedures);

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

				<section>

					<!-- Título -->
					<div class="title-divider">
						<h1>Videos</h1>
					</div>
					<!-- Fin título -->

					<p>
						Bienvenido a nuestra galeria de videos sobre Cirugía Plástica en Colombia.
					</p>

				</section>

				<!-- Listado videos -->
				<?php
					$i = 0;

					foreach($youtube as $item)
					{
						if ($i == 0)
						{
							echo "<div class='row'>";
						}
				?>
						<div class="col m6 s12">
							<a href="video/<?= $item["url"] ?>">
								<div class="card horizontal">
									<div class="card-stacked">
										<div class="card-content" style="height:430px">
											<img src="<?= $item['image'] ?>" width="100%">
											<br><br>
											<h5 class="card-dr-title" style="color:#333"><?= $item["title"] ?></h5>
										</div>
									</div>
								</div>
							</a>
						</div>
				<?php
						if ($i == 1)
						{
							$i = 0;
							echo "</div>";
						}
						else
						{
							$i++;
						}
					}
				?>
				<!-- Fin listado videos -->

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
