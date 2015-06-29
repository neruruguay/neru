<form method="get" action="<?php echo \SKTURL; ?>Google_Search/" class="form-group">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-sm-8 col-md-10">
                <div class="search-area-division search-area-division-input">
                    <input type="text" class="form-control search-query" id="search-term" name="q" placeholder="Escribe tu b&uacute;squeda...">
                </div>
            </div>
            <div class="col-xs-2 col-sm-4 col-md-2">
                <button class="btn btn-block btn-white search-btn fontweb" type="submit"><?php echo \SKT_ADMIN_TXT_SearchSubmit; ?><span class="hidden-xs"> Buscar</span></button>
            </div>
        </div>
    </div>
</form>