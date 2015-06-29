<?php if (isset($_GET['uAction']) && $_GET['uAction'] == "0") { ?>
    <div class="container Company-page" id="FirstSteps">
        <div  class="row">
            <div class="mt30 col-md-12 col-xs-12">
                <h1 class="text-left text-color"><i class="skt-icon-config"></i> Primeros pasos</h1>
            </div>
        </div>
        <hr>
        <div class="row alert alert-warning">
            <div class="text-center">
                <div class="gap"></div>
                <h3>Ya que es nuevo/a por aquí, le contaremos como funciona todo...</h3>
                <h5>Queremos ayudarte a sacar el mayor probecho de nuestros servicios.</h5>
                <div class="gap"></div>
                <button class="btn btn-primary btn-mega" id="demo" data-demo=""><i class="skt-icon-play"></i> Iniciar el Tour</button>
                <div class="gap-small"></div>
                <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/flechasTeclado.png" alt="Luego de iniciar el Tour podr&aacute; desplazarse con las flechas Izqierda y Derecha del teclado" />
                <div class="gap-small"></div>
                <span class="size-2-i">Luego de iniciar el Tour podr&aacute; desplazarse con las flechas Izqierda y Derecha del teclado.</span>
                <div class="gap"></div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 text-center">
                        <div style=" width: 150px; margin: 0 auto;">
                            <button type="button" onclick="ViewHelp<?php echo $User->id ?>();" class="btn btn-primary" >No volver a mostrar</button>
                        </div>
                    </div>
                    <div class="col-md-6 text-left hidden">
                        <a class="link" href="<?php echo \UserProfileLink; ?>">Saltar este paso e ir a tu perfil</a>
                    </div>
                </div>
                <div class="gap"></div>
            </div> 
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    var UserProfileLink = '<?php echo \UserProfileLink; ?>';
    var UserEditLink = '<?php echo \EditLink; ?>';
    var UserTour = true;
    (function () {
        $(function () {
            var $demo, duration, remaining, tour;
            $demo = $("#demo");
            duration = 5000;
            remaining = duration;
            tour = new Tour({
                onStart: function () {
                    $('#FirstSteps').slideUp(400);
                    return $demo.addClass("disabled", true);
                },
                onEnd: function () {
                    $('#FirstSteps').slideDown(1500);
                    return $demo.removeClass("disabled", true);
                },
                template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button><span data-role='separator'>|</span><button class='btn btn-default' data-role='next'>Siguiente »</button><button class='btn btn-default float-right' data-role='end'>Finalizar el Tour</button></div></nav></div>",
                //container: ".global-wrap",
                debug: true,
                steps: [
                    {
                        path: UserProfileLink,
                        element: "#UserMenuStepOne",
                        placement: "left",
                        title: "Bienvenido!",
                        content: "Este es su men&uacute; de acciones, aqu&iacute; podr&aacute; acceder a editar su perfil, publicar productos y ver los mensajes que reciba.<br><br><b>Luego de finalizado el Tour podrá acceder a este y otros Tutoriales desde el link de Tutoriales en el menú.</b>",
                        //orphan: true,
                        onShow: function () {
                            setTimeout(function () {
                                $('#personMarkup .dropdown-menu').show();
                            }, 1000);
                        }
                    }, {
                        path: UserProfileLink,
                        element: "#CompanyLogo",
                        placement: "right",
                        title: "Logotipo",
                        content: "Editando su perfil podr&aacute; cargar una imagen desde su equipo.",
                        onShow: function () {
                            setTimeout(function () {
                                $('#personMarkup .dropdown-menu').hide();
                            }, 500);
                        }
                    }, {
                        path: UserProfileLink,
                        element: "#CompanyDesciption",
                        placement: "top",
                        title: "Información general",
                        content: "El nombre de la Empresa y su actividad en un resumen",
                        onShow: function () {
                            setTimeout(function () {
                                $('#CompanyDesciption').html('<h5>Una breve descripci&oacute;n de su empresa se mostrar&aacute; a los visitantes...</h5><div class="gap-small"></div>');
                            }, 500);
                        }
                    }, {
                        path: UserProfileLink,
                        element: "#masonrylistDemo",
                        placement: "top",
                        title: "Sus Productos",
                        content: "Este es un ejemplo, aquí se mostraran los productos que publique.",
                        onShow: function () {
                            var $masonrylist = $('.masonrylist');
                            $masonrylist.show();
                            $masonrylist.masonry({
                                itemSelector: '.col-masonry'
                            });
                        }
                    }, {
                        path: UserProfileLink,
                        element: "#CompanyContactInfo",
                        placement: "top",
                        title: "Informaci&oacute;n de Contacto",
                        content: "Solo los usuarios registrados podran ver esta informaci&oacute;n de contacto",
                    }, {
                        path: UserProfileLink,
                        element: "#map_canvas",
                        placement: "top",
                        title: "Mapa de ubicación",
                        content: "Aquí se mostrará su ubicaci&oacute;n",
                    }, {
                        path: UserProfileLink,
                        element: "#UserMenuStepOne",
                        placement: "left",
                        title: "Manos a la obra... Completemos el Perfil!",
                        content: "Lo ayudaremos a optimizar los datos para lograr un mayor alcance de contactos y clientes.<br> Se recargar&aacute; la p&aacute;gina...",
                        onShow: function () {
                            setTimeout(function () {
                                $('#personMarkup .dropdown-menu').show();
                                $('.personMarkup .dropdown-menu > li > a.skt-icon-edit').parent().addClass('active');
                            }, 500);
                        },
                        onHidden: function () {
                            return window.location.assign(UserEditLink);
                        }
                    }, {
                        path: UserEditLink,
                        element: "#DumySetNewImageUpload",
                        placement: "right",
                        title: "Logotipo",
                        content: "Haga click aqu&iacute; para cargar una imagen desde su equipo.",
                        onShow: function () {
                            $('li[data-link="#DataCompanyProfile"]').trigger('click');
                        }
                    }, {
                        path: UserEditLink,
                        element: "#DescriptionCompany",
                        placement: "left",
                        title: "Breve descripci&oacute;n",
                        content: "Escriba una descripción de su actividad, productos y/o intereses.",
                        onShow: function () {
                            $('li[data-link="#DataCompanyProfile"]').trigger('click');
                        }
                    }, {
                        path: UserEditLink,
                        element: "#UpdateDataUser",
                        placement: "top",
                        title: "Guardar cambios",
                        content: "Cuando tenga completados los datos Guarde los cambios.",
                        onNext: function () {
                            $('li[data-link="#DataCompanyLocation"]').trigger('click');
                            initMap();
                        }
                    }, {
                        path: UserEditLink,
                        element: "#map_canvas_change",
                        placement: "top",
                        title: "Mapa de ubicaci&oacute;n",
                        content: "Haciendo click sobre el mapa podr&aacute; indicar la ubicaci&oacute;n y el zoom deseado.",
                        delay: 1500,
                        onNext: function () {
                            $('li[data-link="#DataCompanyCategories"]').trigger('click');
                        }
                    }, {
                        path: UserEditLink,
                        element: "#UpdateCategoriesArea",
                        placement: "top",
                        title: "Categor&iacute;as",
                        content: "Indique hasta un m&aacute;ximo de 5 categor&iacute;as que se relacionan con su actividad.<br>&Eacute;stas le permitiran mostrar sus productos en las p&aacute;ginas y b&uacute;squedas con mayor presici&oacute;n, as&iacute; como posicionarse en los rubros de su inter&eacute;s.",
                        delay: 1500,
                        onNext: function () {
                            $('li[data-link="#DataCompanyInterests"]').trigger('click');
                        }
                    }, {
                        path: UserEditLink,
                        element: "#UpdateInterestsArea",
                        placement: "top",
                        title: "Temas de inter&eacute;s",
                        content: "Indique hasta un m&aacute;ximo de 5 temas.<br>Mediante estos datos podremos establecer pautas que nos permitan colaborar con usted evitando molestias innecesarias.",
                        delay: 1500,
                        onNext: function () {
                            tour.end();
                        }
                    }
                ]
            }).init();
            if (tour.ended()) {
                $('#FirstSteps').slideDown(1500);
            }
            $(document).on("click", "[data-demo]", function (e) {
                e.preventDefault();
                if ($(this).hasClass("disabled")) {
                    return;
                }
                tour.restart();
            });
        });
    }).call(this);

    function ViewHelp<?php echo $User->id ?>() {
        var UrlViewHelp = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UpdateData');
        var ID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlViewHelp,
            'cache': false,
            'data': '&ID=' + ID + '&ViewHelp=0',
            'success': function (data) {
                $('#SKT_UpdateDataInfo').slideDown(500).html('Puede acceder nuevamente a la ayuda desde el men&uacute; de usuario.<img src="/_FileSystems/help_arrow.png" alt=""/  style="float: right; margin-top: -51px;">');
                $('#FirstSteps').slideUp(800);
                $('#SKT_UpdateDataInfo').delay(10000).slideUp(500);
            }
        });
    }

</script>