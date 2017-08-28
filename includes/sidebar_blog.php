				<?php
					require_once("admin/models/Doctors.php");

					$doctors = new Doctors();
					$lastDoctors = $doctors->GetLastDoctors();
				?>
				
				<div class="side-bar-block">

					<div class="title-divider">
						<h1>Especialistas</h1>
					</div>

					<div class="collection">

						<?php
							while ($Doctor = $lastDoctors->fetch(PDO::FETCH_ASSOC))
							{
								$content = 'medicos';
								$id = $Doctor["DoctorId"];
								$name = '<strong>Médico No.'.$id.'</strong> ('.$Doctor['Name'].')';
								$logo = ($Doctor['Logo'] != '') ? 'admin/img/doctors/'.$Doctor['Logo'] : 'images/placeholder.jpg';
						?>
								<a href="doctor/<?= $id ?>_<?= slugify($Doctor['Name']) ?>" class="collection-item avatar truncate valigncenter">
									<div class="circle" style="background-image: url(<?= $logo ?>); background-size: cover; background-position: center;"></div>
									<span class="title">Dr. <?= $Doctor['Name'] ?></span>
								</a>
						<?php
							}
						?>
					</div>

				</div>

				<div class="side-bar-block">

					<!-- Instagram -->
					<div class="title-divider">
						<h1>Instagram</h1>
					</div>
					<!-- fin de Instagram -->

					<!-- LightWidget WIDGET -->
					<script src="http://lightwidget.com/widgets/lightwidget.js"></script>
					<iframe src="http://lightwidget.com/widgets/54c4fae719f658e4b3f64ed599628176.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe>

				</div>