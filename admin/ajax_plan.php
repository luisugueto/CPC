<?php
	require_once("models/Plans.php");
	require_once("models/Doctors.php");
	require_once("models/Clients.php");
	include("includes/functions.php");

	$doctor = new Doctors();
	$client = new Clients();

	$plan = new Plans();
  $planList = $plan->ListPlans();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}

	else
	{
		$id = '0';
	}

	$registro = array(
		'PlanId' => $id
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':

			break;

			case 'form':
				if($id != '0')
				{
					$doctor->setDoctorId($id);
					$content = $doctor->GetDoctorContent();

					$client->setClientId($content['ClientId']);
					$clientContent = $client->GetClientContent();

					$plan->setPlanId($content['PlanId']);
					$contentPlan = $plan->GetPlanContent();

					$apiKey = "2rckmqh47vn40optfgon816ghf";

					$merchantId = "504777";

					$amount = $contentPlan['Price'];
					$code = generarCodigo(9);
					$referenceCode = "PCPC-".$code;

					$currency = "COP";

					$firma_digital = $apiKey."~".$merchantId."~".$referenceCode."~".$amount."~".$currency;

					$signature = md5($firma_digital);

					$descripcion = "Pago del Plan de Cirugía Plastica: ".$contentPlan['Name']. " bajo el Cliente: ".$clientContent['Name']."";
				}
			break;

			case 'delete':
				if($id != '0')
				{

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
      	<h2>Planes</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
              <form method="post" action="https://gateway.payulatam.com/ppp-web-gateway/" id="payUForm">
								<h6>El Plan a pagar es: <?=$contentPlan['Name']?> con un costo de <?=$contentPlan['Price'] ?></h6>
								<!-- <div class="form-group">
	                  <div class="col-sm-6">
	                    <label class="col-sm-3 control-label">Plan a Pagar</label>
											<?= $id ?>
	                    <select id="plan" class="form-control select" onchange="plan()" required>
	                      <option value="" disabled selected>Seleccione</option>
	                      <?php
	                        while ($Plan = $planList->fetch(PDO::FETCH_ASSOC))
	                        {
	                      ?>
	                      <option value="<?= $Plan['PlanId'] ?>"><?= $Plan['Name'] ?> - <?= $Plan['Price'] ?></option>
	                      <?php
	                        }
	                      ?>
	                    </select>
	                  </div>
	              </div> -->
								<input type="hidden" id="plan" value="<?= $contentPlan['PlanId'] ?>">

                <input name="merchantId" type="hidden" value="504777">

                  <input name="accountId" type="hidden" value="505738" >
                  <input name="description" type="hidden" value="<?= $descripcion ?>">
                  <input name="referenceCode" id="referenceCode" type="hidden" value="<?= $referenceCode ?>">
                  <input name="amount" type="hidden" value="<?= $amount ?>">
                  <input name="tax" type="hidden" value="0">

                  <input name="taxReturnBase" type="hidden" value="0">

                  <input name="currency" type="hidden" value="<?= $currency ?>">
                  <input name="signature" id="signature" type="hidden" value="<?= $signature ?>">

                  <input name="telephone" id="telephone" type="hidden" value="<?= $clientContent['LocalPhone'] ?>">

                  <input name="buyerEmail" id="buyerEmail" type="hidden" value="<?= $clientContent['Email'] ?>">

                  <input name="buyerFullName" id="buyerFullName" type="hidden" value="<?= $clientContent['Name'] ?>">

                  <input name="responseUrl" id="responseUrl" type="hidden" value="" >

                  <input name="confirmationUrl" id="confirmationUrl" type="hidden" value="">

                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" id="submitPayment" onclick="submitPayment()"><img src="https://www.payulatam.com/wp-content/uploads/2017/02/payu@2x.png" alt="PayU Latam" border="0" /></a>
      </div>
    </div>
</div>

<script type="text/javascript">

  function plan(){
    var value = $("#plan").val();
    getPlan(value);
  }

	function submitPayment(){
			var doctor = <?= $id ?>;
			$.ajax({
	  		data: { planId : $("#plan").val(), doctorID: doctor },
	  		type: 'GET',
	  		url: 'controllers/RegisterPayment.php',
	  		contentType: "application/json; charset=utf-8",
	  		dataType: "json",
	  		success: function (data) {

	  		},
	  		error: function (xhr, status){
	  			var err = eval("(" + xhr.responseText + ")");
	  			alert("Error" + err.Message);
	  		}
	  	});

			$('#payUForm').submit();
	}

  function getPlan(id) {
  	$.ajax({
  		data: { planId : id},
  		type: 'GET',
  		url: 'controllers/GetPlan.php',
  		contentType: "application/json; charset=utf-8",
  		dataType: "json",
  		success: function (data) {
        var amount = data.Price;
  			getSignature(amount);
  		},
  		error: function (xhr, status){
  			var err = eval("(" + xhr.responseText + ")");
  			alert("Error" + err.Message);
  		}
  	});
  }

  function getSignature(amount) {

  	$.ajax({
  		data: { amount : amount},
  		type: 'GET',
  		url: 'controllers/Signature.php',
  		contentType: "application/json; charset=utf-8",
  		dataType: "json",
  		success: function (data) {
        $("#referenceCode").val(data.referenceCode)
        $("input[name='amount']").val(data.amount);
        $("#signature").val(data.signature)
  		},
  		error: function (xhr, status){
  			var err = eval("(" + xhr.responseText + ")");
  			alert("Error" + err.Message);
  		}
  	});

  }

</script>
<?php
	}
?>

<?php
	if($_POST['action'] == 'form_add')
	{

		require_once("models/Users.php");
		require_once("models/Doctors.php");

	  $users = new Users();
	  $users->setUserId($_COOKIE['UserId']);
	  $contentUser = $users->GetUserContent();

	  if($contentUser['Type']=='Client')
	  {
	    $doctor = new Doctors();
	    $doctor->setClientId($contentUser['TypeId']);
	  	$doctorList = $doctor->ListDoctorsForClientwithPlan();
			$doctors = $doctor->ListDoctorsForClient();
	  }
		else{
			exit();
		}
?>
<script src="custom.js"></script>
<script src="functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h2>Planes</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
              <form method="post" action="https://gateway.payulatam.com/ppp-web-gateway/" id="payUForm" data-parsley-validate novalidat>
								<div class="form-group">
	                  <div class="col-sm-12">
	                    <label class="col-sm-3 control-label">Médico</label>
	                    <select class="form-control select" required id="medico">
	                      <option value="" disabled selected>Seleccione</option>
	                      <?php
														while ($Doctorr = $doctors->fetch(PDO::FETCH_ASSOC))
		                        {
															$doctor->setDoctorId($Doctorr['DoctorId']);
															if(!$doctor->existsDoctor()){
																echo "<option value='".$Doctorr['DoctorId']."'>".$Doctorr['Name']." - ".$Doctorr['Description']."</option>";
															}
														}
	                      ?>
	                    </select>
	                  </div>
	              </div>

								<div class="form-group">
	                  <div class="col-sm-12">
	                    <label class="col-sm-3 control-label">Plan a Pagar</label>
	                    <select id="plan" class="form-control select" onchange="plan()" required>
	                      <option value="" disabled selected>Seleccione</option>
	                      <?php
	                        while ($Plan = $planList->fetch(PDO::FETCH_ASSOC))
	                        {
	                      ?>
	                      <option value="<?= $Plan['PlanId'] ?>"><?= $Plan['Name'] ?> - <?= $Plan['Price'] ?></option>
	                      <?php
	                        }
	                      ?>
	                    </select>
	                  </div>
	              </div>

                <input name="merchantId" type="hidden" value="504777">

                  <input name="accountId" type="hidden" value="505738" >
                  <input name="description" type="hidden" value="Plan Cirugía Plástica Colombia">
                  <input name="referenceCode" id="referenceCode" type="hidden" value="PCPC-1">
                  <input name="amount" type="hidden" value="20000">
                  <input name="tax" type="hidden" value="0">

                  <input name="taxReturnBase" type="hidden" value="0">

                  <input name="currency" type="hidden" value="COP">
                  <input name="signature" id="signature" type="hidden" value="">

                  <input name="telephone" id="telephone" type="hidden" value="">

                  <input name="buyerEmail" id="buyerEmail" type="hidden" value="">

                  <input name="buyerFullName" id="buyerFullName" type="hidden" value="">

                  <input name="responseUrl" id="responseUrl" type="hidden" value="" >

                  <input name="confirmationUrl" id="confirmationUrl" type="hidden" value="">

                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" id="submitPayment" onclick="submitPayment()"><img src="https://www.payulatam.com/wp-content/uploads/2017/02/payu@2x.png" alt="PayU Latam" border="0" /></a>
      </div>
    </div>
</div>

<script type="text/javascript">

  function plan(){
    var value = $("#plan").val();
		alert(value);
    getPlan(value);
  }

	function submitPayment(){
		$('#payUForm').parsley().validate();

		if ($('#payUForm').parsley().isValid()){
			var doctor = $("#medico").val();
			debugger;
			$.ajax({
	  		data: { planId : $("#plan").val(), doctorID: doctor },
	  		type: 'GET',
	  		url: 'controllers/RegisterPayment.php',
	  		contentType: "application/json; charset=utf-8",
	  		dataType: "json",
	  		success: function (data) {

	  		},
	  		error: function (xhr, status){
	  			var err = eval("(" + xhr.responseText + ")");
	  			alert("Error" + err.Message);
	  		}
	  	});

			$('#payUForm').submit();
		}
	}

  function getPlan(id) {
  	$.ajax({
  		data: { planId : id},
  		type: 'GET',
  		url: 'controllers/GetPlan.php',
  		contentType: "application/json; charset=utf-8",
  		dataType: "json",
  		success: function (data) {
        var amount = data.Price;
  			getSignature(amount);
  		},
  		error: function (xhr, status){
  			var err = eval("(" + xhr.responseText + ")");
  			alert("Error" + err.Message);
  		}
  	});
  }

  function getSignature(amount) {

  	$.ajax({
  		data: { amount : amount},
  		type: 'GET',
  		url: 'controllers/Signature.php',
  		contentType: "application/json; charset=utf-8",
  		dataType: "json",
  		success: function (data) {
        $("#referenceCode").val(data.referenceCode)
        $("input[name='amount']").val(data.amount);
        $("#signature").val(data.signature)
  		},
  		error: function (xhr, status){
  			var err = eval("(" + xhr.responseText + ")");
  			alert("Error" + err.Message);
  		}
  	});

  }

</script>
<?php
	}
?>
