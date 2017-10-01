				<footer class="footer text-right">
					<div class="container">
						<div class="row">
							<div class="col-xs-9">
							<?= date("Y") ?> © Cirugía Plástica Colombia - Doopla Marketing || Desarrollado por: <a href="http://www.pixelgrafia.com" target="_blank"><img src="img/pixelgrafia.png"></a>
							</div>
							<div class="col-xs-3">
								<ul class="pull-right list-inline m-b-0">
									<li>
										<a href="mailto:soporte@dooplamarketing.com">Ayuda</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<?php
			require_once("models/Publicitys.php");

			$Publicitys = new Publicitys();
			$publicityList = $Publicitys->ListPublicitys();


			while ($Publicitys = $publicityList->fetch(PDO::FETCH_ASSOC))
			{
				echo rawurldecode($Publicitys['Content']);
			}
		 ?>

		<!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-tagsinput.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/plugins/select2/select2.min.js" type="text/javascript"></script>

        <script src="js/slim.kickstart.min.js"></script>
        <script src="functions.js"></script>

		<script src="js/moment.js"></script>
		<script src="js/cropper.min.js"></script>

		<script src="js/bootstrap-datetimepicker.js"></script>
		<script src="js/bootstrap-switch.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/jquery.cropit.js"></script>
		<script src="js/jquery.gridster.min.js"></script>
		<script src="js/jquery.iframe-transport.js"></script>
		<script src="js/jquery.slugify.js"></script>
		<script src="js/jquery.tablednd.js"></script>

		<script src="js/slugify.js"></script>
		<script src="js/speakingurl.min.js"></script>

        <!-- Sweet-Alert  -->
		<script src="assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
		<script src="assets/pages/jquery.sweet-alert.init.js"></script>

		<!-- Parsleyjs -->
		<script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.min.js"></script>
		<script src="assets/plugins/parsleyjs/src/i18n/es.js"></script>

        <!-- BEGIN PAGE SCRIPTS -->
        <script src="assets/plugins/moment/moment.js"></script>
        <script src='assets/plugins/fullcalendar/dist/fullcalendar.js'></script>
        <script src='assets/plugins/fullcalendar/dist/lang/es.js'></script>
				<script src='assets/js/jquery.dataTables.min.js'></script>
				<script src='assets/js/dataTables.bootstrap.min.js'></script>
				<script type="text/javascript">
					$('#example').DataTable();
					$('#example1').DataTable();
				</script>
	</body>
</html>
