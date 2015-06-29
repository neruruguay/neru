<style type="text/css">#FirstSteps{display: none !important;}</style>
<div class="container Company-page">
    <h2 class=" mt20 mb20 text-color"><i class="skt-icon-edit"></i> Editar Perfil</h2>
    <div class="row">
        <div class="col-md-3">
            <aside class="sidebar-left">
                <ul class="nav nav-pills nav-stacked nav-arrow" id="DataCompanyMenu">
                    <li class="active" data-link="#DataCompanyProfile"><a href="javascript:void(0);" class="skt-icon-ok-circled2"> Datos generales</a></li>
                    <li data-link="#DataCompanyLocation"><a href="javascript:initMap();" class="skt-icon-location"> Mapa de Ubicación</a></li>
                    <li data-link="#DataCompanyCategories"><a href="javascript:void(0);" class="skt-icon-tags"> C&iacute;rculos Empresariales</a></li>
                    <li data-link="#DataCompanyInterests"><a href="javascript:void(0);" class="skt-icon-lightbulb"> Intereses</a></li>
                    <li data-link="#DataUpdatePassword"><a href="javascript:void(0);" class="skt-icon-rewrite"> Cambiar contrase&ntilde;a</a></li>
                    <li><a class="skt-icon-image" href="<?php echo \DesignLink;?>"> Estilo personalizado</a></li> 
                </ul>
            </aside>
        </div>
        <div class="col-md-9" id="DataForms">
            <div class="row row-wrap" id="DataCompanyProfile">
                <div class="col-md-12"><h4 class="text-color skt-icon-ok-circled2">Datos de la empresa</h4></div>
                <div class="col-md-3">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'EditAvatar.php');
                    ?>
                </div>
                <div class="col-md-9">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'EditData.php');
                    ?>
                </div>
                <div class="gap"></div>
            </div>
            <div class="row row-wrap" id="DataCompanyLocation" style="display: none;">
                <div class="col-md-12">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'EditLocation.php');
                    ?>
                </div>
                <div class="gap"></div>
            </div>

            <div class="row row-wrap" id="DataCompanyCategories" style="display: none;">
                <div class="col-md-12">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'EditCategories.php');
                    ?>
                </div>
                <div class="gap"></div>
            </div>

            <div class="row row-wrap" id="DataCompanyInterests" style="display: none;">
                <div class="col-md-12">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'EditInterests.php');
                    ?>
                </div> 
                <div class="gap"></div>
            </div>
            
            <div class="row row-wrap" id="DataUpdatePassword" style="display: none;">
                <div class="col-md-12">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'SetPassword.php');
                    ?>
                </div> 
                <div class="gap"></div>
            </div>
        </div>
    </div>
    <div class="gap"></div>
</div>
<script type="text/javascript">
    var DataCompanyMenu = $('#DataCompanyMenu');
    DataCompanyMenu.find('li').click(function (e) {
        if (!$(this).hasClass('active')) {
            DataCompanyMenu.find('li').removeClass('active');
            $(this).addClass('active');
            $('#DataForms > div').slideUp(1000);
            $($(this).attr('data-link')).slideDown(1000);
            e.stopPropagation();
        }
    });
</script>