$(window).on('load', function() {
    $("#pageloader").fadeOut("slow");
});

$(function() {
    $(window).scroll(function() {
        var goUpArrow = $("#gouparrow");
        var pTop = $('body').scrollTop();

        if (pTop == 0) {
            goUpArrow.attr("style", "opacity:0")
        }
        if (pTop > 4) {
            goUpArrow.attr("style", "opacity:0.1")
        }
        if (pTop > 30) {
            goUpArrow.attr("style", "opacity:0.2")
        }
        if (pTop > 60) {
            goUpArrow.attr("style", "opacity:0.3")
        }
        if (pTop > 90) {
            goUpArrow.attr("style", "opacity:0.4")
        }
        if (pTop > 110) {
            goUpArrow.attr("style", "opacity:0.5")
        }
        if (pTop > 140) {
            goUpArrow.attr("style", "opacity:0.6")
        }
        if (pTop > 170) {
            goUpArrow.attr("style", "opacity:0.7")
        }
        if (pTop > 200) {
            goUpArrow.attr("style", "opacity:0.8")
        }
        if (pTop > 230) {
            goUpArrow.attr("style", "opacity:0.9")
        }
        if (pTop > 243) {
            goUpArrow.attr("style", "opacity:1")
        }
        if (pTop > 500) {
            goUpArrow.attr("style", "opacity:1")
        }
    });
});

function modalCallSite(content,action,id,args) {

    $('.modal').modal();

    if (typeof args == 'undefined') {
        args = '';
    }

    var file = 'ajax_' + content + '.php';
    var modal = $('#modal-001');
    modal.modal('open');

    $.post(file, { action: action, id: id, args: args }, function(returned) {
        modal.html(returned);
    });

};


function submitModalSite(content) {
    $('#modalForm').parsley().validate();
    
    if ($('#modalForm').parsley().isValid()){
        var modal = $('#modal-001');
        $("#pageloader").fadeIn();
        modal.modal('close');

        $.ajax({
            type: "POST",
            url: 'ajax_'+content+'.php',
            data: $('#modalForm').serialize(),
            dataType: "json",
            success: function (data) {

                $("#pageloader").fadeOut();

                if(data.trim() == "exito") {
                    swal({
                        title: "Guardado",
                        text: "Tus cambios han sido guardados correctamente.",
                        type: "success",
                        confirmButtonColor: "#00a5dd",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: false
                    }, function(){
                        $('.sweet-alert').hide();
                        $('.sweet-overlay').hide();
                        $('#pageloader').fadeIn();
                        location.reload();
                    });

                } else {
                    swal({
                        html:true,
                        title: "Error",
                        text: "Ha ocurrido un error al guardar en la base de datos: <br/>" + data,
                        type: "error",
                        confirmButtonColor: "#0059a5",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    });

                }
            },
            error: function(err) {
                $("#pageloader").fadeOut();
                alert("Error: " + err);
                console.log(JSON.stringify(err));
            }
        });
    }
};

function submitModalsSite(content, title, msg) {
    $('#modalForm').parsley().validate();
    
    if ($('#modalForm').parsley().isValid()){
        var modal = $('#modal-001');
        $("#pageloader").fadeIn();
        modal.modal('close');
    
        
        $.ajax({
            type: "POST",
            url: 'ajax_'+content+'.php',
            data: $('#modalForm').serialize(),
            dataType: "json",
            success: function (data) {

                $("#pageloader").fadeOut();

                if(data.trim() == "exito") {
                    swal({
                        title: title,
                        text: msg,
                        type: "success",
                        confirmButtonColor: "#00a5dd",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: false
                    }, function(){
                        $('.sweet-alert').hide();
                        $('.sweet-overlay').hide();
                        $('#pageloader').fadeIn();
                        location.reload();
                    });

                } else {
                    swal({
                        html:true,
                        title: "Error",
                        text: "Ha ocurrido un error al guardar en la base de datos: <br/>" + data,
                        type: "error",
                        confirmButtonColor: "#0059a5",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    });

                }
            },
            error: function(err) {
                $("#pageloader").fadeOut();
                alert("Error: " + err);
                console.log(JSON.stringify(err));
            }
        });
    }
};

function submitComentario() {
    $('#comentarioForm').parsley().validate();
    if ($('#comentarioForm').parsley().isValid()){
        var formData = new FormData($("#comentarioForm")[0]);
        var ruta = "ajax_comentario.php";
        var modal = $('#modal-001');
        $("#pageloader").fadeIn();
        modal.modal('close');
        $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                
                $("#pageloader").fadeOut();

                if(data.trim() == "exito") {
                    swal({
                        title: "Guardado",
                        text: "Tus cambios han sido guardados correctamente.",
                        type: "success",
                        confirmButtonColor: "#00a5dd",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: false
                    }, function(){
                        $('.sweet-alert').hide();
                        $('.sweet-overlay').hide();
                        $('#pageloader').fadeIn();
                        location.reload();
                    });

                } else {
                    swal({
                        html:true,
                        title: "Error",
                        text: "Ha ocurrido un error al guardar en la base de datos: <br/>" + data,
                        type: "error",
                        confirmButtonColor: "#0059a5",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    });

                }
            },
            error: function(err) {
                $("#pageloader").fadeOut();
                alert("Error: " + err);
                console.log(JSON.stringify(err));
            }
        });
    }
};

function verifyCode() {
    var id = $('input[name="DoctorId"]').val();
    var cod = $('#cod').val();

    if (cod.trim() == '') {
        $('#verifyCode').text('');
        $('input[name="txtCode"]').remove();
    }else{
        $.ajax({
            data: { doctorId : id, code : cod},
            type: 'GET',
            url: 'admin/controllers/VerifyCode.php',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                if(response == 'exito'){
                    $('#verifyCode').text('Código Correcto');
                    $('#code').append('<input type="hidden" name="txtCode" value="1">');
                }
                else{
                    $('#verifyCode').text('Código Incorrecto');
                    $('input[name="txtCode"]').remove();
                }
            },
            error: function (xhr, status){
                var err = eval("(" + xhr.responseText + ")");
                alert("Error" + err.Message);
            }
        });
    }
};