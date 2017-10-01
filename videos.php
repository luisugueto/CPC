<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(5);
	$contentSection = $section->GetSectionContent();
 	include("includes/header.php");

	function getYoutubeVideos($playlistID)
	{
		$list = $playlistID;
		$key = "AIzaSyBMKyjwq9euxN_XvJrehe8gN_ZbSKym-2A";
		$maxVideos = "30";

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

					for ($v = 0; $v < 10; $v++)
					{
						if ($i == 0)
						{
							echo "<div class='row'>";
						}
				?>
						<div class="col m6 s12">
							<a href="video/<?= $youtube[$v]["url"] ?>">
								<div class="card horizontal">
									<div class="card-stacked">
										<div class="card-content" style="height:430px">
											<img src="<?= $youtube[$v]['image'] ?>" width="100%">
											<br><br>
											<h5 class="card-dr-title" style="color:#333"><?= $youtube[$v]["title"] ?></h5>
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

					if (count($youtube) > 10)
					{

				?>

				<div class="container" id="showMore-1">
					<div class="row">
						<div class="col s12 m12 center-align">
							<a class="waves-effect waves-light btn" href="javascript:void(0)" onclick="showMoreVideos(1)" style="border-radius: 30px; background-color: #03a5dd;">Ver más</a>
						</div>
					</div>
				</div>

				<div id="videos-1" style='display:none;'>
				
				<?php
						$i = 0;
						
						for ($v = 10; $v < 20; $v++)
						{
							if (isset($youtube[$v]["title"]))
							{
								if ($i == 0)
								{
									echo "<div class='row'>";
								}
				?>
								<div class="col m6 s12">
									<a href="video/<?= $youtube[$v]["url"] ?>">
										<div class="card horizontal">
											<div class="card-stacked">
												<div class="card-content" style="height:430px">
													<img src="<?= $youtube[$v]['image'] ?>" width="100%">
													<br><br>
													<h5 class="card-dr-title" style="color:#333"><?= $youtube[$v]["title"] ?></h5>
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
						}
					}
				?>

				</div>

				<?php
					if (count($youtube) > 20)
					{

				?>

				<div class="container" id="showMore-2">
					<div class="row">
						<div class="col s12 m12 center-align">
							<a class="waves-effect waves-light btn" href="javascript:void(0)" onclick="showMoreVideos(2)" style="border-radius: 30px; background-color: #03a5dd;">Ver más</a>
						</div>
					</div>
				</div>

				<div id="videos-2" style='display:none;'>

				<?php
						$i = 0;
						
						for ($v = 20; $v < 30; $v++)
						{
							if (isset($youtube[$v]["title"]))
							{
								if ($i == 0)
								{
									echo "<div class='row'>";
								}
				?>
								<div class="col m6 s12">
									<a href="video/<?= $youtube[$v]["url"] ?>">
										<div class="card horizontal">
											<div class="card-stacked">
												<div class="card-content" style="height:430px">
													<img src="<?= $youtube[$v]['image'] ?>" width="100%">
													<br><br>
													<h5 class="card-dr-title" style="color:#333"><?= $youtube[$v]["title"] ?></h5>
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
						}
				?>
						</div>
				<?php
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

	<script>
		function showMoreVideos(i) {
			$("#videos-" + i).fadeIn(500);
			$("#showMore-" + i).fadeOut(500);
		}
	</script>