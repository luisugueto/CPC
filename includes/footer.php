    <?php
		require_once("admin/models/Articles.php");
		$articles_footer = new Articles();
		$lastArticles = $articles_footer->LastArticlesFooter();
	?>
	
	<!-- Footer -->
	<footer class="page-footer">
		<div class="container">
			<div class="row">
				<div class="col m4 s12">
					<img src="images/logo-footer.png" width="50%">
					<br>
					<p style="text-align:justify">Cirugia Plastica Colombia es el portal de la estética y de la cirugia plastica en Colombia, el cual busca promover las buenas prácticas en la industria de la cirugia plastica y estetica en Colombia, proporcionando información veraz, oportuna y actualizada sobre la oferta de procedimientos y especialistas certificados, facilitando a los pacientes una elección responsable y segura de sus intervenciones medicas y esteticas.</p>
				</div>
				<div class="col m4 s12">
					<h5>Últimas Entradas:</h5>
					<div class="row" style="margin:0;">
						<ul class="collection" style="border: none;">
							<?php
								while ($article_footer = $lastArticles->fetch(PDO::FETCH_ASSOC))
								{
							?>
									<a class="collection-item avatar truncate cirujanos" href="noticia/<?= $article_footer["ArticleId"] ?>_<?= $article_footer["Slug"] ?>" style="background-color: transparent; border: none;">
										<div class="circle" style="background-image: url(images/blog/<?= $article_footer["Photo"] ?>)"></div>
										<span class="title" style="text-decoration: underline;"><?= $article_footer["Title"] ?></span>

										<?php
											$d_footer = date_parse($article_footer["PublishDate"]);
											$monthNum_footer = $d_footer["month"];
											$months_footer = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
											$monthName_footer = $months_footer[$monthNum_footer - 1];
										?>

										<p style="color:#b3b3b3; font-size:12px">
											<?= $monthName_footer ?> <?= $d_footer["day"] ?>, <?= $d_footer["year"] ?>
										</p>
									</a>
							<?php
								}
							?>
						</ul>
					</div>
				</div>
				<div class="col m4 s12">
					<h5>Para Anunciantes:</h5>
					<ul>
						<!--<li><a class="grey-text" href="http://doopla.co/" target="_blank">Sobre nosotros</a></li>
						<li><a class="grey-text" href="http://doopla.co/productos/cirugiaplasticacolombia" target="_blank">Pauta</a></li>-->
						<li><a style="text-decoration:underline;" href="contacto">Paute con nosotros</a></li>
						<li><a style="text-decoration:underline;" href="javascript:void(0)">Términos y condiciones</a></li>
						<li><a style="text-decoration:underline;" href="javascript:void(0)">Normas de privacidad</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container" style="margin-bottom: 8px;">
				<div class="row" style="margin-bottom: 0">
					<div class="col s6">
						© <?= date("Y") ?> Cirugía Plástica Colombia
					</div>
					<div class="col s6 right-align">
						Desarrollado por: <a href="http://www.pixelgrafia.com/" target="_blank"><img src="images/pixelgrafia.png" height="20" style="position: relative; top: 5px;"></a>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- Fin Footer -->

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

	<script src="admin/assets/js/modernizr.min.js"></script>
	<script src="js/functions.js"></script>

	<script src="admin/assets/js/bootstrap.min.js"></script>
	<script src="admin/assets/js/jquery.blockUI.js"></script>

	<!-- Sweet-Alert  -->
	<script src="admin/assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
	<script src="admin/assets/pages/jquery.sweet-alert.init.js"></script>

	<!-- Parsleyjs -->
	<script type="text/javascript" src="admin/assets/plugins/parsleyjs/dist/parsley.min.js"></script>
	<script src="admin/assets/plugins/parsleyjs/src/i18n/es.js"></script>

    <!-- Switcher -->
    <script src="switcher/mail-form-switch/mail_functions.js"></script>
    <script src="switcher/mail-form-switch/validator.min.js"></script>

	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>
	<script type="text/javascript">

		$("#consulta-en-linea").click(function() {
			ga('send', 'event', 'Botones', 'click', 'Consulta en línea');
		});

		$("#action-block-qualify").click(function() {
			ga('send', 'event', 'Bloque de Acción', 'click', 'Calificar');
		});

		$("#header-qualify").click(function() {
			ga('send', 'event', 'Bloque de Acción', 'click', 'Calificar');
		});

		// Función para mostrar menú responsive.
		$(".button-collapse").sideNav();

		function goUp() {
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}

		function closePrincipalModal() {
			$("#modal-001").modal("close");
		};

		$(document).ready(function () {
			$('.modal').modal();

			$('.tooltipped').tooltip({delay: 50});

			$('#dropdown-desk').dropdown({
				inDuration: 300,
				outDuration: 225,
				constrainWidth: false,
				hover: true,
				gutter: 0,
				belowOrigin: true,
				alignment: 'left',
				stopPropagation: false
			});

			$('#dropdown-mobile').dropdown({
				inDuration: 300,
				outDuration: 225,
				constrainWidth: false,
				hover: false,
				gutter: 0,
				belowOrigin: true,
				alignment: 'left',
				stopPropagation: false
			});

			// Script para el auto completar del input de búsqueda
			$("#autocomplete-input").autocomplete({
				// Sugerencias:
				data: <?= json_encode($arrayMerge) ?>,
				limit: 20, // Máximo de resultados. Por defecto es infinito.
				onAutocomplete: function (val) {
					// Función cuando se seleccione el auto completar.
					/*var regex = /\[([^\]]+)]/g,
				    match,
				    resultado = [], type = "";

				    while ((match = regex.exec(val)) !== null) {
						resultado.push(match[1]);
					}

					switch (resultado[0]) {
						case 'Procedimiento':
							type="procedimiento/search"
							break;
						case 'Doctor':
							type="doctor/search"
							break;
						default:

					}*/
					$("#formSearch").attr('action', "doctor/search");
				},
				minLength: 2, // Minimo de caracteres para mostrar las sugerencias
			});

			$('.owl-carousel').owlCarousel({
				loop: false,
				margin: 10,
				dots: true,
				merge: true,
				nav: false,
				dotsContainer: "#customDots",
				responsive : {
					0 : {
						items: 1
					},
					768 : {
						items: 2
					},
					998 : {
						items: 3
					}
				}
			});
		});

		function toPosition(pos) {
			$('.owl-carousel').trigger('to.owl.carousel', [pos, 200]);
		}
	</script>
</body>

</html>
