;
function removeOnlyUA(Cssclass) {
    var x = document.querySelectorAll(Cssclass);
    if (x.length > 0) {
        for (i = 0; i < x.length; i++) {
            x[i].remove();
        }
    }
}
var agent = navigator.userAgent.toLowerCase(), isUAMobile = false, isUATablet = false, isUADesktop = true;
if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(agent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(agent.substr(0, 4))) {
    isUATablet = false;
    isUAMobile = true;
    isUADesktop = false;
}
if (!!(agent.match(/(iPad|SCH-I|xoom|NOOK|silk|kindle|GT-P|touchpad|kindle|sch-t|viewpad|bolt|playbook|Nexus 7|Nexus 10)/i)
        || ((agent.match(/(JZO54K)/i)) && !(agent.match(/(mobile)/i)))
        || ((agent.match(/(JDQ39)/i)) && !(agent.match(/(mobile)/i)))
        || ((agent.match(/(KOT49H)/i)) && !(agent.match(/(mobile)/i)))
        || ((agent.match(/(JZO54K)/i)) && (agent.match(/(UCBrowser)/i)))
        || ((agent.match(/(JZO54K)/i)) && (agent.match(/(SM-T210)/i)))
        )) {
    isUATablet = true;
    isUAMobile = false;
    isUADesktop = false;
}
if ((isUATablet || isUAMobile)) {
    if (isUATablet) {
        removeOnlyUA('OnlyMobile');
        removeOnlyUA('OnlyDesktop');
        $(document).ready(function () {
            InitMasonry();
        });
    }
    if (isUAMobile) {
        removeOnlyUA('OnlyTablet');
        removeOnlyUA('OnlyDesktop');
    }
    $(document).ready(function () {
        InitRightPush();
    });
} else {
    removeOnlyUA('OnlyMobile');
    removeOnlyUA('OnlyTablet');
    $(document).ready(function () {
        InitMasonry();


        // Bootstrap tooltips
        $('[data-toggle="tooltip"]').tooltip();
        // Checkboxes and radio
        $('.i-check, .i-radio').iCheck({
            checkboxClass: 'i-check',
            radioClass: 'i-radio'
        });
        // footer always on bottom
        var docHeight = $(window).height();
        var footerHeight = $('footer').height();
        var footerTop = $('footer').position().top + footerHeight;
        if (footerTop < docHeight) {
            $('footer').css('margin-top', (docHeight - footerTop) + 'px');
        }
        removeOnlyUA('OnlyMobile');
        removeOnlyUA('OnlyTablet');
    });
}

	
	// ============= SUBSCRIBE FORM VALIDATIONS SETTINGS ========================  
          
    $('#subscribe_form').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.closest("form"));
        },
        messages: {
            email: {
                required: "Necesitamos que escriba su email",
                email: "Escriba un email v&aacute;lido"
            }
        },
					
        highlight: function(element) {
            $(element)
        },                    
					
        success: function(element) {
            element
            .text('').addClass('valid')
        }
    }); 
		
				

// ============= SUBSCRIBE FORM MAILCHIMP INTEGRATIONS SCRIPT ========================  
		
    $('#subscribe_form').submit(function() {
        $('.error').hide();
        $('.error').fadeIn();
        // submit the form
        if($(this).valid()){
            $('#subscribe_submit').button('loading'); 
            var action = $(this).attr('action');
            $.ajax({
                url: action,
                type: 'POST',
                data: {
                    newsletter_email: $('#subscribe_email').val(),
                    newsletter_name: $('#subscribe_name').val(),
                    newsletter_surname: $('#subscribe_surname').val()
                },
                success: function(data) {
                    $('#subscribe_submit').button('reset');
                    $('.error').html(data);
                },
                error: function() {
                    $('#subscribe_submit').button('reset');
                    // Change subscribe form error message text here
                    $('.error').html('Oops! Algo no anda bien!');
                }
            });
        // return false to prevent normal browser submit and page navigation 
        }
        return false; 
    });
	  
// Masonry
function InitMasonry() {
    if ($(window).width() > 992) {
        var $masonrylist = $('.masonrylist');
        setTimeout(function () {
            $masonrylist.masonry({
                itemSelector: '.col-masonry'
            });
        }, 1000);
    }
}
// Lighbox text
$('.popup-text').magnificPopup({
    removalDelay: 500,
    closeBtnInside: true,
    callbacks: {
        beforeOpen: function () {
            this.st.mainClass = this.st.el.attr('data-effect');
        }
    },
    midClick: true
});
// Lightbox iframe
$('.popup-iframe').magnificPopup({
    dispableOn: 700,
    type: 'iframe',
    removalDelay: 160,
    mainClass: 'mfp-fade',
    preloader: false});
// Document ready functions
$(document).ready(function () {
    $('#flexnav').flexNav();
    var owlCarousel = $('#owl-carousel'),
            owlItems = owlCarousel.attr('data-items'),
            owlCarouselSlider = $('#owl-carousel-slider');
    owlCarousel.owlCarousel({
        items: owlItems,
        center: true,
        loop: true,
        nav: true,
        autoplay: true,
        autoplayHoverPause: true,
        navigation: true,
        navigationText: ['', '']
    });
    owlCarouselSlider.owlCarousel({
        slideSpeed: 300,
        paginationSpeed: 400,
        center: true,
        autoplay: true,
        autoplayHoverPause: true,
        singleItem: true,
        navigation: true,
        transitionStyle: 'goDown',
        navigationText: ['', '']
    });

    // Countdown
    $('.countdown').each(function () {
        var count = $(this);
        $(this).countdown({
            zeroCallback: function (options) {
                $(count).removeClass('countdown').html('Producto finalizado');
                /*var newDate = new Date(),
                 newDate = newDate.setHours(newDate.getHours() + 130);
                 $(count).attr("data-countdown", newDate);
                 $(count).countdown({
                 unixFormat: true
                 });*/
            }
        });
    });
    
	
	// ============= SUBSCRIBE FORM VALIDATIONS SETTINGS ========================  
          
    $('#FormNewsletter').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.closest("form"));
        },
        messages: {
            email: {
                required: "Necesitamos que escriba su email",
                email: "Escriba un email v&aacute;lido"
            }
        },
					
        highlight: function(element) {
            $(element)
        },                    
					
        success: function(element) {
            element
            .text('').addClass('valid')
        }
    }); 
		
				

// ============= SUBSCRIBE FORM MAILCHIMP INTEGRATIONS SCRIPT ========================  
		
    $('#FormNewsletter').submit(function() {
        $('.error').hide();
        $('.error').fadeIn();
        // submit the form
        if($(this).valid()){
            $('#subscribe_submit').button('loading'); 
            var action = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Mailer/subscribe');
            $.ajax({
                url: action,
                type: 'POST',
                data: {
                    newsletter_email: $('#subscribe_email').val()
                },
                success: function(data) {
                    $('#subscribe_submit').button('reset');
                    $('.error').html(data);
                },
                error: function() {
                    $('#subscribe_submit').button('reset');
                    // Change subscribe form error message text here
                    $('.error').html('Oops! Algo no anda bien!');
                }
            });
        // return false to prevent normal browser submit and page navigation 
        }
        return false; 
    });
	  
    /*-----------------------------------------------------------------------------------------------*/
    
});
function ActivateRightPush() {
    if ($('#RightPush').length) {
        if ($(window).width() < 769) {
            $("#showRightPush").toggleClass('active');
            $("body").toggleClass('cbp-spmenu-push-toleft');
            $("#RightPush").toggleClass('cbp-spmenu-open');
        }
    }
}
function InitRightPush() {
    if ($('#RightPush').length) {
        $('#showRightPush').click(function () {
            $("#showRightPush").toggleClass('active');
            $("body").toggleClass('cbp-spmenu-push-toleft');
            $("#RightPush").toggleClass('cbp-spmenu-open');
        });
    }
}
function viewListStyle(thisbtn, Target, CssClassRemove, CssClassAdd) {
    $(Target).find('.element-item').addClass(CssClassAdd).removeClass(CssClassRemove);
    var $masonrylist = $('.masonrylist');
    $masonrylist.masonry({
        itemSelector: '.col-masonry'
    });
    $(thisbtn).parent().find('a').removeClass('active');
    $(thisbtn).addClass('active');
}
function viewListFilter(Target, CssClassFilter) {
    if (CssClassFilter != 0) {
        $(Target + ' .element-item.Cat-' + CssClassFilter).show();
        $(Target + ' .element-item:not(".Cat-' + CssClassFilter + '")').hide();
    } else {
        $(Target + ' .element-item').show();
    }
    var $masonrylist = $(Target);
    $masonrylist.masonry({
        itemSelector: '.col-masonry'
    });
}