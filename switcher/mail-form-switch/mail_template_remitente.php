<?php
ob_start();
?>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  </head>
  <body>
  	<table width="320" cellpadding="10" cellspacing="0" style="color: #000000; background-color: #fcfcfc;">
      <tr>
        <td align="center" style="height:70px; padding: 10px; font-size:13px; font-family:Arial, Helvetica, sans-serif; background:#E9E9E9;"><img src="logo.png" height="63"></td>
      </tr>
      <tr >
        <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666; padding:40px;">
          <br/>
          <span style="font-size:19px;">Hola <b><?php echo $ToName; ?></b>,</span><br/>
          <br/>
          Gracias por contactar a <strong><?php echo $formData['switchToName']; ?></strong>
          <br/>
          Estos son los datos enviados desde el formulario de contacto en el perfil de <strong><?php echo $formData['switchToName']; ?></strong> en <a href="http://cirugiaplasticacolombia.com" target="_blank"><strong>www.cirugiaplasticacolombia.com</strong></a>
          <br/>
          <br/>
          <?php 
			foreach($formData['content'] as $datos){
				echo "<b>".$datos['showtitle']."</b>: ".nl2br($datos['value'])."<br>";
			}
			?>
          <br>
          <br/>
        </td>
      </tr>
      <tr>
         <td style="background:#E9E9E9; font-family:Arial, Helvetica, sans-serif; font-size:13px;  text-align: center; padding:10px; color:#666;">
         <strong><a href="http://cirugiaplasticacolombia.com" target="_blank"><strong>www.cirugiaplasticacolombia.com</strong></a></strong>
         <br>
         <span style="font-size:10px;">
         Este es un correo automático enviado a <a href="mailto:<?php echo $ToEmail; ?>" target="_blank"><?php echo $ToEmail; ?></a>, por favor no responda este correo. <br>
         </span>
         </td>
      </tr>
      <tr>
         <td><a href="http://dooplamarketing.com" target="_blank"><img src="banner-email-form-visitante.jpg" alt="Doopla Marketing" width="320"></a></td>
      </tr>
    </table>
  </body>
</html>
<?php
$content = ob_get_contents();
ob_end_clean();
return($content);
?>