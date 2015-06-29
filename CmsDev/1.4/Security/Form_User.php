<form method="post" action="?">
    <div class="control-group">
        <label class="control-label" for="inputLoginLogin">
            Nombre de usuario
            <span class="form-required" title="This field is required.">*</span>
        </label>
        <div class="controls">
            <input name="SKT_UserName" class="form-control" title="<?php echo SKT_ADMIN_TXT_Email ?>" type="text" value="" size="30" maxlength="30" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputLoginPassword">
            <?php echo SKT_ADMIN_TXT_Password ?>
            <span class="form-required" title="This field is required.">*</span>
        </label>
        <div class="controls">
            <input name="SKT_Password" type="password" class="form-control" title="<?php echo SKT_ADMIN_TXT_Password ?>" value="" size="30" maxlength="30" />
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo SKT_ADMIN_Btn_Acept ?>" class="btn btn-primary arrow-right">
    </div>
</form>