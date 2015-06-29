<form method="POST" id="UpdateData<?php echo $User->id ?>">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Nombre de la empresa</label>
                <input value="<?php echo $User->Company; ?>" name="Company" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>RUT</label>
                <input value="<?php echo $User->RUT; ?>" name="RUT" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Direcci&oacute;n:</label>
                <input value="<?php echo $User->Address; ?>" name="Address" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Descripci&oacute;n</label>
                <textarea name="Description" id="DescriptionCompany" class="form-control" style="height: 80px;"><?php echo $User->Description; ?></textarea>
            </div>
        </div>
        <div class="col-md-12"><h4 class="text-color">Informaci&oacute;n de Contacto</h4></div>
        <div class="col-md-4">   
            <div class="form-group">
                <label>Nombre</label>
                <input value="<?php echo $User->Name; ?>" name="Name" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-4">   
            <div class="form-group">
                <label>Apellido</label>
                <input value="<?php echo $User->Surname; ?>" name="Surname" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-4">           
            <div class="form-group">
                <label>Cargo</label>
                <input value="<?php echo $User->Position; ?>" name="Position" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-12"><h4 class="text-color">Informaci&oacute;n de Contacto</h4></div>
        <div class="col-md-4">   
            <div class="form-group">
                <label>E-mail:</label>
                <input value="<?php echo $User->email; ?>" name="email" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-4">   
            <div class="form-group">
                <label>Web:</label>
                <input value="<?php echo $User->website; ?>" name="website" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-4">           
            <div class="form-group">
                <label>Tel&eacute;fono</label>
                <input value="<?php echo $User->Phone; ?>" name="Phone" type="text" class="form-control" />
            </div>
        </div>
    </div>
</form>
<button type="button" onclick="UpdateData<?php echo $User->id ?>();" id="UpdateDataUser" class="right btn btn-primary btn-lg float-right" ><i class="skt-icon-ok-circled2"></i> Guardar Datos de Empresa/Persona</button>
<script type="text/javascript">

    function UpdateData<?php echo $User->id ?>() {
        var UrlUpdateData = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UpdateData');
        var ID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlUpdateData,
            'cache': false,
            'data': $('#UpdateData<?php echo $User->id ?>').serialize() + '&ID=' + ID,
            'success': function (data) {
                $('#SKT_UpdateDataInfo').html(data).show();
                $('.mfp-close').trigger('click');
                setTimeout(function () {
                    $('#SKT_UpdateDataInfo').hide();
                    $('#SKT_UpdateDataInfo').html('');
                }, 3500);
            }
        });
    }

</script>