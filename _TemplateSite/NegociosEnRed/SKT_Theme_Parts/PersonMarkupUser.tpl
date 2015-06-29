<div class="skt personMarkup" style="margin-top:4px;" id="personMarkup">
    <sktAvatar>
        <a href="{NameLink}" title="{NameText}" class="thumb" ><img id="ImageProfile" src="{Avatar}" width="40px"/></a>
    </sktAvatar>
    <span class="MobileName hidden-md hidden-lg">{NameText}</span>
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <span id="User_{UserID}">{NameText} {MessagerCountTop} </span> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" style="left: auto; right: 0px; padding: 0px ! important; max-width: none;">

        <!-- Init Options for user has Logged Publisher-->
        <sktUserOptions>
            <!-- <li><a class="{ServiceProvider}SP" href="{NameLink}" target="_blank" ><span>{NameText} (Perfil)</span></a></li> -->
            <li><a class="skt-icon-page-properties" href="{ProfileLink}" ><span>{ProfileText}</span></a></li>
            {Messager}
            <!--<li><a class="skt-icon-lightbulb" href="{PublisherLink}" ><span>Publicar / Vender</span></a></li>-->
            <li><a class="skt-icon-basquet" href="{ResumenLink}" ><span>Resumen de cuenta e Hist&oacute;rico</span></a></li>
            <li><a class="skt-icon-edit" href="{EditLink}" > <span>Editar Perfil y datos</span></a></li>
            <li><a class="skt-icon-image" href="{DesignLink}" ><span>Estilo personalizado</span></a></li> 
            <li><a class="skt-icon-help" href="{HelpLink}"><span>Ayuda</span></a></li>
            <li><a class="skt-icon-exit" href="{LogoutLink}"><span>{LogoutText}</span></a></li>
        </sktUserOptions>
        <!-- Init Options for user has Logged Publisher-->


        <!-- Init Options for user has Logged Customer-->
        <sktUserOptionsCustomer>
            <li><a class="skt-icon-google-plus {ServiceProvider}SP" href="{NameLink}" target="_blank" ><span>{NameText} (Perfil)</span></a></li>
            {Messager}
            <li><a class="skt-icon-basquet" href="{ResumenLink}" ><span>Mis Compras</span></a></li> 
            <li><a class="skt-icon-edit" href="{EditLink}" > <span>Editar Perfil y datos</span></a></li>
            <li><a class="skt-icon-help" href="{HelpLink}"><span>Ayuda</span></a></li>
            <li><a class="skt-icon-exit" href="{LogoutLink}"><span>{LogoutText}</span></a></li>
        </sktUserOptionsCustomer>
        <!-- Init Options for user has Logged Customer-->


        <!-- Init Options for user access -->
        <sktloginoptions>
            <sktgenericuseraccess>
                <li>
                    <a class="LoginLink sktToolTip" href="{UserLoginLink}" title="{UserLoginTitle}">{UserLoginText}</a>
                </li>
                <li>
                    <a class="RegisterLink white sktToolTip" href="{RegisterLink}" title="{RegisterTitle}">{RegisterText}</a>
                </li>
            </sktgenericuseraccess>
            <sktgoogleaccess>
                <li>
                    <a class='ConnectGoogle sktToolTip' title="{GoogleLoginTitle}" href='{GoogleLoginLink}'>{GoogleLoginText}</a>
                </li>
            </sktgoogleaccess>
        </sktloginoptions>
        <!-- End Options for user access -->

    </ul>
    <sktSell>
        <a class="skt-publisher skt-icon-lightbulb" href="{PublisherLink}" ><span> Vender</span></a>
    </sktSell>
</div>