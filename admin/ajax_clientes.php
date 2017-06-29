<?php
	require_once("models/Clients.php");
	include("includes/functions.php");
	$clients = new Clients();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['ClientId']))
	{
		$id = $_POST['ClientId'];
	}
	else
	{
		$id = '0';
	}

	$registro = array(
		'ClientId' => $id,
		'BusinessName' => '',
		'Identification' => '',
		'Name' => '',
		'Email' => '',
		'MobilePhone' => '',
		'LocalPhone' => '',
		'Address' => '',
		'City' => '',
		'Address2' => '',
		'Country' => '',
		'Discount' => '0',
		'Calification' => '1'
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$clients->setClientId(GetSQLValueString($_POST["ClientId"], "text"));
					$clients->setBusinessName(GetSQLValueString($_POST["txtBusinessName"], "text"));
					$clients->setIdentification(GetSQLValueString($_POST["txtIdentification"], "text"));
					$clients->setName(GetSQLValueString($_POST["txtName"], "text"));
					$clients->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));
					$clients->setMobilePhone(GetSQLValueString($_POST["txtMobilePhone"], "text"));
					$clients->setLocalPhone(GetSQLValueString($_POST["txtLocalPhone"], "text"));
					$clients->setAddress(GetSQLValueString($_POST["txtAddress"], "text"));
					$clients->setCity(GetSQLValueString($_POST["txtCity"], "text"));
					$clients->setAddress2(GetSQLValueString($_POST["txtAddress2"], "text"));
					$clients->setCountry(GetSQLValueString($_POST["txtCountry"], "text"));
					$clients->setDiscount(GetSQLValueString($_POST["txtDiscount"], "text"));
					$clients->setCalification(GetSQLValueString($_POST["txtCalification"], "text"));
					echo json_encode($clients->UpdateClient());
				}
				else
				{
					$clients->setBusinessName(GetSQLValueString($_POST["txtBusinessName"], "text"));
					$clients->setIdentification(GetSQLValueString($_POST["txtIdentification"], "text"));
					$clients->setName(GetSQLValueString($_POST["txtName"], "text"));
					$clients->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));
					$clients->setMobilePhone(GetSQLValueString($_POST["txtMobilePhone"], "text"));
					$clients->setLocalPhone(GetSQLValueString($_POST["txtLocalPhone"], "text"));
					$clients->setAddress(GetSQLValueString($_POST["txtAddress"], "text"));
					$clients->setCity(GetSQLValueString($_POST["txtCity"], "text"));
					$clients->setAddress2(GetSQLValueString($_POST["txtAddress2"], "text"));
					$clients->setCountry(GetSQLValueString($_POST["txtCountry"], "text"));
					$clients->setDiscount(GetSQLValueString($_POST["txtDiscount"], "text"));
					$clients->setCalification(GetSQLValueString($_POST["txtCalification"], "text"));
					echo json_encode($clients->CreateClient());
				}
			break;

			case 'form':
				if($id != '0')
				{
					$clients->setClientId($id);
					$registro = $clients->GetClientContent();
				}
			break;
			case 'delete':
				if($id != '0')
				{
					$plans->setClientId($id);
					echo json_encode($plans->DeleteClient());
                    exit();
				}
			break;
		}
	}

?>
<?php
	if($_POST['action'] == 'form')
	{
?>

<script src="custom.js"></script>
<script src="functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h2>Cliente</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="ClientId" value="<?php echo $registro['ClientId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['ClientId'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Razón Social</label>
                        <div class="col-sm-6">
                            <input name="txtBusinessName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['BusinessName'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NIT/CC</label>
                        <div class="col-sm-6">
                            <input name="txtIdentification" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Identification'];?>"/>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre de contacto</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <textarea name="txtEmail" class="form-control" parsley-trigger="change" required><?php echo $registro['Email'];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Movil</label>
                        <div class="col-sm-6">
                            <input name="txtMobilePhone" type="text" class="form-control" placeholder="" value="<?php echo $registro['MobilePhone'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Teléfono</label>
                        <div class="col-sm-6">
                            <input name="txtLocalPhone" type="text" class="form-control" placeholder="" value="<?php echo $registro['LocalPhone'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Dirección</label>
                        <div class="col-sm-6">
                            <textarea name="txtAddress" class="form-control"><?php echo $registro['Address'];?></textarea>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ciudad</label>
                        <div class="col-sm-6">
                            <input name="txtCity" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['City'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Departamento</label>
                        <div class="col-sm-6">
                            <input name="txtAddress2" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Address2'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">País</label>
                        <div class="col-sm-6">
                            <input name="txtCountry" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Country'];?>"/>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Descuento</label>
                        <div class="col-sm-6">
                            <input name="txtDiscount" type="text" class="form-control" data-parsley-type="digits" parsley-trigger="change" required min="0" max="100" placeholder="Numero entre 0 - 100" value="<?php echo $registro['Discount'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Calificacion</label>
                        <div class="col-sm-6">
                            <input name="txtCalification" type="text" class="form-control" data-parsley-type="digits" parsley-trigger="change" required min="0" max="5" placeholder="Numero entre 0 - 5" value="<?php echo $registro['Calification'];?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('clientes');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>
<?php } ?>
<?php if($_POST['action'] == 'view'){?>
<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h4 class="m-t-0 m-b-5"><b><?php echo $registro['BusinessName'];?></b></h4>
        <p class="text-muted">NIT/CC: <?php echo $registro['Identification'];?></p>
      </div>
      <div id="modal-result" class="modal-body">
            <div class="row">
            	<div class="col-md-6">
                    <p class="text-dark">
                        <i class="fa fa-user"></i> <small><?php echo $registro['Name'];?></small><br>
                        <i class="fa fa-envelope"></i> <small><?php echo $registro['Email'];?></small><br>
                        <i class="fa fa-phone-square"></i> <small><?php echo $registro['MobilePhone'];?></small><br>
                        <i class="fa fa-phone-square"></i> <small><?php echo $registro['LocalPhone'];?></small><br>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="text-dark">
                        <i class="fa fa-phone-square"></i> <small><?php echo $registro['Address'];?></small><br>
                        <i class="fa fa-phone-square"></i> <small><?php echo $registro['City'];?></small><br>
                        <i class="fa fa-phone-square"></i> <small><?php echo $registro['Address2'];?></small><br>
                        <i class="fa fa-phone-square"></i> <small><?php echo $registro['Country'];?></small><br>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <ul class="social-links list-inline m-0">
                    <li><button class="btn btn-white waves-effect waves-light"> <i class="fa fa-percent m-r-5"></i> <span><?php echo $registro['Discount'];?></span> </button></li>
                    <li><button class="btn btn-white waves-effect waves-light">
                    	<?php
							$emptyStars = 5-$registro['Calification'];
							for ($i = 1; $i <= $registro['Calification']; $i++) {
								echo '<i class="fa fa-star m-r-5"></i>';
							}
							for ($i = 1; $i <= $emptyStars; $i++) {
								echo '<i class="fa fa-star-o m-r-5"></i>';
							}
						?>
                        </button>
                   </li>
                    </ul>
                </div>
            </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
</div>

<?php
	}
?>
