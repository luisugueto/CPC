    <?php
		require_once("admin/models/Doctors.php");
		$doctor = new Doctors();
		$lastDoctors = $doctor->GetLastDoctors();

		require_once("admin/models/Categories.php");
		$categories = new Categories();
		$categoriesList = $categories->ListCategories();
	?>
	
	<!-- Footer -->
	<footer class="page-footer">
		<div class="container">
			<div class="row">
				<div class="col m4 s12">
					<h5 class="white-text">Nosotros</h5>
					<ul>
						<li><a class="grey-text text-lighten-3" href="http://doopla.co/" target="_blank">Sobre nosotros</a></li>
						<li><a class="grey-text text-lighten-3" href="http://doopla.co/productos/cirugiaplasticacolombia" target="_blank">Pauta</a></li>
						<li><a class="grey-text text-lighten-3" href="contacto">Contáctanos</a></li>
					</ul>
				</div>
				<div class="col m4 s12">
					<h5 class="white-text">Especialistas</h5>
					<ul>
						<?php
							while ($doctor = $lastDoctors->fetch(PDO::FETCH_ASSOC))
							{
						?>
								<li><a class="grey-text text-lighten-3" href="doctor/<?= $doctor["DoctorId"] ?>_<?= slugify($doctor["Name"]) ?>">Dr <?= $doctor["Name"] ?></a></li>
						<?php		
							}
						?>
					</ul>
				</div>
				<div class="col m4 s12">
					<h5 class="white-text">Procedimientos</h5>
					<ul>
						<?php
							while ($Procedures = $categoriesList->fetch(PDO::FETCH_ASSOC))
							{
								echo "<li><a class='grey-text text-lighten-3' href='procedimiento/".$Procedures['CategoryId']."_".slugify($Procedures['Name'])."'>".$Procedures['Name']."</a></li>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container" style="margin-bottom: 8px;">
				<div class="row" style="margin-bottom: 0">
					<div class="col s6">
						© <?= date("Y") ?> <a href="http://doopla.co" target="_blank" style="margin-left:5px; margin-right:5px;"><img src="images/doopla.png" style="position: relative; top: 8px;"></a>
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

		$(document).ready(function () {
			$('.tooltipped').tooltip({delay: 50});

			$('.dropdown-button').dropdown({
				inDuration: 300,
				outDuration: 225,
				constrainWidth: false,
				hover: true,
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
					var regex = /\[([^\]]+)]/g,
				    match,
				    resultado = [], type = "";

				    while ((match = regex.exec(val)) !== null) {
				    	resultado.push(match[1]);
						}

					switch (resultado[0]) {
						case 'Procedimiento':
							type="procedimientos-detalle.php"
							break;
						case 'Doctor':
							type="directorio-detalle.php"
							break;
						default:

					}
					$("#formSearch").attr('action', type);
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
