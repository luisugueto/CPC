    <!-- Footer -->
	<footer class="page-footer">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text">Cirugía plástica Colombia</h5>
					<p class="grey-text text-lighten-4">Lorem ipsum, dolor sit amet.</p>
				</div>
				<div class="col l4 offset-l2 s12">
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				© 2017 Dooplamarketing. Desarrollado por: <a href="http://www.pixelgrafia.com/" target="_blank">Pixelgrafía</a>
			</div>
		</div>
	</footer>
	<!-- Fin Footer -->

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>
	<script type="text/javascript">
		// Función para mostrar menú responsive.
		$(".button-collapse").sideNav();

		$(document).ready(function () {
			// Script para el auto completar del input de búsqueda
			$(".autocomplete").autocomplete({
				// Sugerencias:
				data: {
					"Dr John Garcia": null,
					"Procedimiento 1": null
				},
				limit: 20, // Máximo de resultados. Por defecto es infinito.
				onAutocomplete: function (val) {
					// Función cuando se seleccione el auto completar.
				},
				minLength: 3, // Minimo de caracteres para mostrar las sugerencias
			});

			$('.owl-carousel').owlCarousel({
				loop: false,
				margin: 10,
				dots: false,
				merge: true,
				nav: false,
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
	</script>
</body>

</html>