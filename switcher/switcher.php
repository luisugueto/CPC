<?php 
include('switcher/functions.php');
$Image = '';
$Text = '';
$executeSwitch = '';
if(isset($_GET['lps']) && $_GET['lps'] != ''){
	$varURL = 'info='.$_GET['lps'];
	$executeSwitch = '1';
}elseif(isset($_GET['lpid']) && $_GET['lpid'] != ''){
	$varURL = 'id='.$_GET['lpid'];
	$executeSwitch = '1';
}

if($executeSwitch == '1'){
	$switchData = getApiData('http://dooplamarketing.com/dooplatools/feed/api-switcher.php?'.$varURL);
	if(isset($switchData) && $switchData != ""){
		$switch_info = unserialize(base64_decode($switchData));
		$lp_config = unserialize(base64_decode($switch_info['lp_config']));


		if(isset($lp_config["css"])){
			$css = '<style type="text/css">';
			$css .='
				#popup , #popup .terms, #popup .terms a, #popup .title{
					color:'.$lp_config["css"]['color1'][1].';
				}
				#popup .terms a:hover{
					color:'.$lp_config["css"]['color2'][0].'!important;
				}
				#popup .btn-primary{
					color:'.$lp_config["css"]['color2'][1].'!important;
					background:'.$lp_config["css"]['color2'][0].'!important;
					border:none;
				}
				#popup .btn-primary:hover {
					opacity: 0.8;
				}
			';
			$css .= '</style>';	
			
			echo $css;
		}

		// Imprimimos Foto y contenido HTML del LP-Popup
		$Image = '';
		if(isset($lp_config) && $lp_config !=''){
			if($lp_config['image'] != ""){
				$Image = '<img src="'.$lp_config['image'].'" alt="Foto" class="img-responsive"/>'; 
			}
			if($lp_config['text'] != ""){
				$Text = '<div class="title">'.$lp_config['text'].'</div>';
			}
		}

		//Formulario bilingue
		$formLangText = array(
			'text1' => 'Nombre',
			'text2' => 'Por favor completar este campo.',
			'text3' => 'E-mail',
			'text4' => 'Correo electrónico inválido.',
			'text5' => 'Teléfono / Celular',
			'text6' => 'Comentarios...',
			'textSend' => 'Enviar'
		);
		if(isset($lp_config['idioma']) && $lp_config['idioma'] == 'en'){
			
			$formLangText = array(
				'text1' => 'Name',
				'text2' => 'Please complete this field.',
				'text3' => 'E-mail',
				'text4' => 'Please enter a valid email address.',
				'text5' => 'Phone number',
				'text6' => 'Comments...',
				'textSend' => 'Send'
			);
		}

		//Datos del destinatario
		if(isset($lp_config["form"]["ToEmail"]) && $lp_config["form"]["ToEmail"] != ''){
			$siteData = array(
				'ToName' => $lp_config["form"]["ToName"],
				'ToEmail' => $lp_config["form"]["ToEmail"],
				'CCO' => $lp_config["form"]["CCO"],
				'switch_id' => $switch_info['switcher_switch_id']
			);
			$siteDataEncrypted = base64_encode(serialize($siteData));
		}

	}
}
?>

<?php if($executeSwitch == '1'){ ?>
<!-- fullscreen-message -->
<link href="switcher/switcher.css" rel="stylesheet">
<div id="popup">
    <div id="popup-frame">
    	<button class="closePopup" onclick="getElementById('popup').style.display = 'none';">x</button>
		<div id="popup-body">
			<?=$Image?>
			<?=$Text?>
			<div id="ajaxResult-ContactForm"></div>
			<form data-toggle="validator" role="form" id="SwitchForm">
			    <input type="hidden" name="site" value="<?php echo $siteDataEncrypted;?>" />
			    <?php if(isset($lp_config['form']['fields']) && in_array('name',$lp_config['form']['fields'])){?>
			    <div class="form-group">
					<input type="text" class="form-control" id="f1-name" name="name" showtitle="<?= $formLangText['text1'];?>" placeholder="<?= $formLangText['text1'];?>" data-error="<?= $formLangText['text2'];?>" required>
					<div class="help-block with-errors"></div>
				</div>
			    <?php }?>
			    
			    <?php if(isset($lp_config['form']['fields']) && in_array('email',$lp_config['form']['fields'])){?>
				<div class="form-group">
					<input type="email" class="form-control" id="f1-email" name="email" showtitle="<?= $formLangText['text3'];?>"  placeholder="<?= $formLangText['text3'];?>" data-error="<?= $formLangText['text4'];?>" required>
					<div class="help-block with-errors"></div>
				</div>
			    <?php }?>
			    
			    <?php if(isset($lp_config['form']['fields']) && in_array('phone',$lp_config['form']['fields'])){?>
				<div class="form-group">
					 <input type="text" class="form-control" id="f1-phone" name="phone" showtitle="<?= $formLangText['text5'];?>" placeholder="<?= $formLangText['text5'];?>" data-error="<?= $formLangText['text2'];?>" required>
					<div class="help-block with-errors"></div>
				</div>
			    <?php }?>

			    <?php if(isset($lp_config['form']['fields']) && in_array('ubicacion',$lp_config['form']['fields'])){?>
				<div class="form-group">
					 <input type="text" class="form-control" id="f1-ubicacion" name="ubicacion" showtitle="Ubicación" placeholder="Tu Ciudad/País" data-error="Escribe tu ciudad y país." required>
					<div class="help-block with-errors"></div>
				</div>
			    <?php }?>
			    
			    <?php if(isset($lp_config['custom_form_html'])){
					echo $lp_config['custom_form_html'];
				}?>
			    
			    <?php if(isset($lp_config['form']['fields']) && in_array('comments',$lp_config['form']['fields'])){?>
				<div class="form-group">
					<textarea rows="5" class="form-control" id="f1-comments" name="comments" showtitle="<?= $formLangText['text6'];?>" placeholder="<?= $formLangText['text6'];?>​" style="height:auto;" data-error="<?= $formLangText['text2'];?>" required></textarea>
					<div class="help-block with-errors"></div>
				</div>
			    <?php }?>
			</form>
			<button class="btn btn-primary btn-lg btn-block" id="SwitchContactSubmit"><?= $formLangText['textSend'];?></button>

			<?php 
				if($lp_config['footer']['text'] != ""){
					echo '<div class="terms"  onclick="ga(\'send\', \'event\', \'Boton\', \'clic\', \'LinkPieDePagina\');"><a href="'.$lp_config['footer']['link'].'" target="_blank">'.$lp_config['footer']['text'].'</a></div>';
					
				}
			?>
	    </div>
    </div>
</div>
<?php } ?>