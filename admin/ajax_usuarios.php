<?php
	require_once("models/Users.php");
	include("includes/functions.php");

	$users = new Users();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['UserId']))
	{
		$id = $_POST['UserId'];
	}
	else
	{
		$id = '0';
	}

	function permisosChecked($permisoValue)
	{
		global $permisos;
		if(is_array($permisos))
		{
			if(in_array($permisoValue, $permisos))
			{
				echo "checked";
			}
		}
	}

	$registro = array(
		'UserId' => $id,
		'Name' => '',
		'Email' => '',
		'Password' => '',
		'Phone' => '',
		'Description' => '',
		'Permissions' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$users->setUserId($id);
					$users->setName(GetSQLValueString($_POST["txtName"], "text"));
					$users->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));

                    if ($_POST["txtPassword"] != "")
                    {
                        $users->setPassword(encrypt_decrypt('encrypt', $_POST["txtPassword"]));
                    }
                    else
                    {
                        $users->setPassword($_POST["hdPassword"]);
                    }

					$users->setPhone(GetSQLValueString($_POST["txtPhone"], "text"));
					$users->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));
					$users->setPermissions(serialize($_POST["Permissions"]));
					echo json_encode($users->UpdateUser());
				}
				else
				{
					$users->setName(GetSQLValueString($_POST["txtName"], "text"));
					$users->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));

                    if ($_POST["txtPassword"] != "")
                    {
                        $users->setPassword(encrypt_decrypt('encrypt', $_POST["txtPassword"]));
                    }
                    else
                    {
                        $users->setPassword($_POST["hdPassword"]);
                    }

					$users->setPhone(GetSQLValueString($_POST["txtPhone"], "text"));
					$users->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));
					$users->setPermissions(serialize($_POST["Permissions"]));
					echo json_encode($users->CreateUser());
				}
			break;

			case 'form':
				if($id != '0')
				{
					$users->setUserId($id);
					$registro = $users->GetUserContent();
					$permisos = unserialize($registro['Permissions']);
				}
			break;

			case 'delete':
				if($id != '0')
				{
					$users->setUserId($id);
					echo json_encode($users->DeleteUser());
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
      	<h2>Usuario</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="UserId" value="<?php echo $registro['UserId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['UserId'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-6">
                            <input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Email'];?>"/>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Contraseña</label>
                        <div class="col-sm-3">
                            <input name="pass2" type="password" id="pass2" class="form-control" placeholder="Contraseña" value=""/>
                        </div>
                        <div class="col-sm-3">
                            <input name="txtPassword" id="txtPassword" type="password" class="form-control" data-parsley-equalto="#pass2" placeholder="Repetir Contraseña" value=""/>
                        </div>
                    </div>

                    <script type="text/javascript">

                        $('#pass2').on('keyup change',function(){
                            if($("#pass2").val() != ''){
                                $("#txtPassword").attr("required", true);
                            }else{
                                $("#txtPassword").attr("required", false);  
                            }
                        });

                    </script>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Teléfono</label>
                        <div class="col-sm-6">
                            <input name="txtPhone" type="text" class="form-control" placeholder="" value="<?php echo $registro['Phone'];?>" required/>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Información adicional</label>
                        <div class="col-sm-6">
                            <textarea name="txtDescription" class="form-control"><?php echo $registro['Description'];?></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="hdPassword" value="<?= $registro['Password'] ?>">

                    <?php
                        $users->setUserId($_COOKIE['UserId']);
                        $usuario = $users->GetUserContent();
                        $permisos_usuario = unserialize($usuario["Permissions"]);
                        if (in_array("per_permisos", $permisos_usuario))
                        {
                    ?>

                            <hr></hr>
                            <h4>Permisos</h4>

                            <table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
                                <thead>
                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width: 80%">Clientes</th>
                                        <th scope="col" style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_clientes" <?php permisosChecked('per_clientes')?>/></th>
                                    </tr>
                                </thead>
                            </table>

                            <br>

                            <table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
                                <thead>
                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width: 80%">Restaurantes</th>
                                        <th scope="col" style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_restaurantes" <?php permisosChecked('per_restaurantes')?>/></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 80%">Información general</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_restaurante_info" <?php permisosChecked('per_restaurante_info')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80%">Mapa</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_restaurante_mapa" <?php permisosChecked('per_restaurante_mapa')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80%">Carta</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_restaurante_carta" <?php permisosChecked('per_restaurante_carta')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80%">Menú del día (Calendario)</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_restaurante_calendario" <?php permisosChecked('per_restaurante_calendario')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80%">Menú del día (Programados)</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_restaurante_programados" <?php permisosChecked('per_restaurante_programados')?>/></td>
                                    </tr>
                                </tbody>
                            </table>

                            <br>

                            <table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
                                <thead>
                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width: 80%">Usuarios</th>
                                        <th scope="col" style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_usuarios" <?php permisosChecked('per_usuarios')?>/></th>
                                    </tr>
                                </thead>
                            </table>

                            <br>

                            <table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
                                <thead>
                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width: 80%">Facturación</th>
                                        <th scope="col" style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_facturacion" <?php permisosChecked('per_facturacion')?>/></th>
                                    </tr>
                                </thead>
                            </table>

                            <br>

                            <table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
                                <thead>
                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width: 80%">Permisos</th>
                                        <th scope="col" style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_permisos" <?php permisosChecked('per_permisos')?>/></th>
                                    </tr>
                                </thead>
                            </table>

                    <?php
                        }
                    ?>

                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('usuarios');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

<?php
	}
?>
