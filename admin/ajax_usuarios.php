<?php
	require_once("models/Users.php");
	require_once("models/Clients.php");
	require_once("models/Doctors.php");
	require_once("models/UserDoctors.php");
	include("includes/functions.php");

	$users = new Users();
	$userDoctors = new UserDoctors();
	$clients = new Clients();
	$clientList = $clients->ListClients();
	$doctors = new Doctors();
	$doctorss = $doctors->ListDoctorsName();

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

                    if(isset($_POST["txtType"]))
                    {
                        if($_POST["txtType"] == 'user_perfil')
                        {
                            $users->setType('Doctor');
                            $users->setTypeId(GetSQLValueString($_POST["doctor"], "text"));
                            echo json_encode($users->UpdateUserPerfil());
                        }
                    }
                    else
                    {
                        echo json_encode($users->UpdateUser());
                    }
				}
				else
				{
					if(isset($_POST["txtType"]))
                    {
						if($_POST["txtType"] == 'perfil')
                        {
							$userDoctors->setDoctorId(GetSQLValueString($_POST["doctor"], "text"));
							$userDoctors->setUserId(GetSQLValueString($_POST["user"], "text"));
							echo json_encode($userDoctors->CreateUserDoctor());
							exit();
						}
					}
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

					if(isset($_POST["txtType"]))
                    {
                        if($_POST["txtType"] == 'user_perfil')
                        {
                            $users->setType('UserDoctor');
                            $users->setTypeId($_POST["txtDoctor"]);
                            echo json_encode($users->CreateUserPerfil());
                            exit();
                        }
                    }
                    else
                    {
                        echo json_encode($users->CreateUser());
                    }
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

			case 'deletePerfil':
				if($id != '0')
				{
					$userDoctors->setUserDoctorsId($id);
					echo json_encode($userDoctors->DeleteUserDoctors());
				}
			break;

            case 'modify_user_perfil':
                if($id != '0')
                {
                    $users->setUserId($id);
                    $registro = $users->GetUserContent();
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
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width: 55%">Sección</th>
                                        <th scope="col" style="width: 15%">Crear</th>
                                        <th scope="col" style="width: 15%">Editar</th>
                                        <th scope="col" style="width: 15%">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 55%">Blog</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_blog_crear" <?php permisosChecked('per_blog_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_blog_editar" <?php permisosChecked('per_blog_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_blog_eliminar" <?php permisosChecked('per_blog_eliminar')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">Médicos</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_medicos_crear" <?php permisosChecked('per_medicos_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_medicos_editar" <?php permisosChecked('per_medicos_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_medicos_eliminar" <?php permisosChecked('per_medicos_eliminar')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">Planes</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_planes_crear" <?php permisosChecked('per_planes_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_planes_editar" <?php permisosChecked('per_planes_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_planes_eliminar" <?php permisosChecked('per_planes_eliminar')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">Procedimientos y Sub Procedimientos</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_procedimientos_crear" <?php permisosChecked('per_procedimientos_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_procedimientos_editar" <?php permisosChecked('per_procedimientos_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_procedimientos_eliminar" <?php permisosChecked('per_procedimientos_eliminar')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">Clientes</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_clientes_crear" <?php permisosChecked('per_clientes_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_clientes_editar" <?php permisosChecked('per_clientes_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_clientes_eliminar" <?php permisosChecked('per_clientes_eliminar')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">Publicidad</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_publicidad_crear" <?php permisosChecked('per_publicidad_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_publicidad_editar" <?php permisosChecked('per_publicidad_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_publicidad_eliminar" <?php permisosChecked('per_publicidad_eliminar')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">Pagos</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_pagos_crear" <?php permisosChecked('per_pagos_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_pagos_editar" <?php permisosChecked('per_pagos_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_pagos_eliminar" <?php permisosChecked('per_pagos_eliminar')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">SEO</td>
                                        <td style="width: 15%"></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_seo_editar" <?php permisosChecked('per_seo_editar')?>/></td>
                                        <td style="width: 15%"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 55%">Usuarios</td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_usuarios_crear" <?php permisosChecked('per_usuarios_crear')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_usuarios_editar" <?php permisosChecked('per_usuarios_editar')?>/></td>
                                        <td style="width: 15%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_usuarios_eliminar" <?php permisosChecked('per_usuarios_eliminar')?>/></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
                                <thead>
                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width:80%">Perfil médico</th>
                                        <th scope="col" style="width: 20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 80%">Información Básica</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_medico_info" <?php permisosChecked('per_medico_info')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80%">Descripción</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_medico_descripcion" <?php permisosChecked('per_medico_descripcion')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80%">Fotos/Videos</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_medico_galeria" <?php permisosChecked('per_medico_galeria')?>/></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80%">Comentar calificaciones</td>
                                        <td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="Permissions[]" value="per_medico_calificaciones" <?php permisosChecked('per_medico_calificaciones')?>/></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
                                <thead>
                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist" style="width:80%">¿Modificar Permisos?</th>
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

<?php
    if($_POST['action'] == 'user_perfil')
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
                    <input type="hidden" name="txtDoctor" value="<?= $id ?>">
                    <input type="hidden" name="txtType" value="user_perfil">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-6">
                            <input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder="" value=""/>
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
                            <input name="txtPhone" type="text" class="form-control" placeholder="" value="" required/>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Información adicional</label>
                        <div class="col-sm-6">
                            <textarea name="txtDescription" class="form-control"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="hdPassword" value="">
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

<?php
    if($_POST['action'] == 'modify_user_perfil')
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
                    <input type="hidden" name="doctor" value="<?= $registro['DoctorId'] ?>">
                    <input type="hidden" name="type" value="user_perfil">
                    <input type="hidden" name="UserId" value="<?php echo $registro['UserId'];?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?= $registro['Name'] ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-6">
                            <input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder="" value="<?= $registro['Email'] ?>"/>
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
                            <input name="txtPhone" type="text" class="form-control" placeholder="" value="<?= $registro['Phone'] ?>" required/>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Información adicional</label>
                        <div class="col-sm-6">
                            <textarea name="txtDescription" class="form-control"><?= $registro['Description'] ?></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="hdPassword" value="">
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

<?php
    if($_POST['action'] == 'perfil_medico')
    {
			$listUsers = $users->ListUser();
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
                    <input type="hidden" name="doctor" value="<?= $id ?>">
                    <input type="hidden" name="txtType" value="perfil">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Usuarios</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="user">
															<<option value="" disabled selected>Seleccione</option>
															<?php
																while($Listado = $listUsers->fetch(PDO::FETCH_ASSOC)){
																	echo "<option value=".$Listado['UserId'].">".$Listado['Name']."</option>";
																}
															?>
                            </select>
                        </div>
                    </div>
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
