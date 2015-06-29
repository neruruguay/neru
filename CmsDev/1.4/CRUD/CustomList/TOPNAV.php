<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"><span style="color: white;">Listas Personalizadas</span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" id="ListActions">
                <li class="AddList"><a href="javascript:CustomListSKT.AddList();"><?php echo \SKT_ADMIN_Lists_NewList; ?></a></li>
                <li class="Editlist disabled"><a href="javascript:CustomListSKT.Editlist();"><?php echo \SKT_ADMIN_Lists_EditListProperties; ?></a></li>
                <li class="ViewItems disabled"><a href="javascript:CustomListSKT.ViewItems();"><?php echo \SKT_ADMIN_Lists_ViewListItems; ?></a></li>
                <li class="AddItem disabled"><a href="javascript:CustomListSKT.AddItem();"><?php echo \SKT_ADMIN_Lists_AddListItem; ?></a></li>
                <li class="GetHowUse disabled"><a href="javascript:CustomListSKT.GetHowUse();"><?php echo \SKT_ADMIN_Lists_GetHowUseLists; ?></a></li>
            </ul>
        </div>
    </div>
</nav>
