jQuery.fn.andSelf = function() {
    return this.addBack.apply(this, arguments);
}

$(document).ready(function () {

    function productHover() {
        $('.portfolio-item > .item-image').each( function() { $(this).hoverdir({
            hoverDelay : 75
        }); } );
    }
    productHover();



    $("#twit").owlCarousel({

        navigation : true, // Show next and prev buttons
        slideSpeed : 100,
        paginationSpeed : 400,
        navigationText : false,
        singleItem: true,
        autoPlay: true,
        pagination: false
    });

    $("#client-speech").owlCarousel({

        autoPlay: 5000, //Set AutoPlay to 3 seconds
        stopOnHover: true,
        singleItem:true
    });

    $('[data-pjax-container]').on('pjax:complete', function (target) {
        if ($(this).closest('.container').find('.sorting-form').length) {
            $('body,html').animate({ scrollTop: $(this).closest('.container').find('.sorting-form:visible').offset().top - 160 }, 500);
            productHover();
        }
    });

    $('.sel').each(function() {
        $(this).children('select').css('display', 'none');

        var $current = $(this);
        var selected = $(this).children('select').find('[selected]');
        var selIndex = $(selected).val().length ? $(selected).index() - 1 : 0;

        $(this).find('option').each(function(i) {
            if (i == 0) {
                $current.prepend($('<div>', {
                    class: $current.attr('class').replace(/sel/g, 'sel__box')
                }));

                var placeholder = $(this).text();
                $current.prepend($('<span>', {
                    class: $current.attr('class').replace(/sel/g, 'sel__placeholder'),
                    text: placeholder,
                    'data-placeholder': placeholder
                }));

                return;
            }

            $current.children('div').append($('<span>', {
                class: $current.attr('class').replace(/sel/g, 'sel__box__options'),
                text: $(this).text()
            }));
        });

        if(selIndex){
            var spanSelected = selected.closest('.sel').find('span.sel__box__options:eq('+ selIndex +')');
            spanSelected.addClass('selected');
            spanSelected.closest('.sel').children('span').text(spanSelected.text()).attr('data-placeholder', spanSelected.text());
        };
    });

// Toggling the `.active` state on the `.sel`.
    $('.sel').click(function() {
        $(this).toggleClass('active');
    });

// Toggling the `.selected` state on the options.
    $('.sel__box__options').click(function() {

        var txt = $(this).text();
        var index = $(this).index();

        $(this).siblings('.sel__box__options').removeClass('selected');
        $(this).addClass('selected');

        var $currentSel = $(this).closest('.sel');
        $currentSel.children('.sel__placeholder').text(txt);
        index++;
        $currentSel.children('select').prop('selectedIndex', index);
        $currentSel.children('select').find('option:eq('+index+')').attr('selected', 'selected').trigger('change');

    });

    $(document).on('click','[data-action="subscribe"]', function () {
        var form = $(this).closest('form');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function (data) {
                if (data) {
                    form.parent().closest('.subscr-foot').html(data);
                }
            }
        }).done(function () {
            var message = $('span.subscribe-message').text();
            var popup = $('[pd-popup="popupSubscribe"]');
            popup.find('.text-message').text(message);
            popup.fadeIn(100);
        });
    });

    $(document).on('click', '[pd-popup-close]', function(e)  {
        $(this).closest('div.popup').fadeOut(200);
        e.preventDefault();
    });

    $(document).on('click', '.pulse .bloc', function () {
       location.href = $(this).attr('data-href');
    });


    var navFixed = $("nav.nofixed"),
        navHeight = $('nav').height();

    if ($(window).scrollTop()) {
        navFixed.addClass("fixed-menu").removeClass("nofixed");
    };


    if (navFixed.length) {
        $(window).scroll(function(){
            var scroll = $(window).scrollTop();
            // console.log($('span.span-fixed').text(scroll));

            if (scroll < navHeight + 50) {
                navFixed.addClass("nofixed");
                navFixed.removeClass("fixed-menu hidden-menu");
            };
            if (scroll > navHeight){
                navFixed.addClass("hidden-menu");
            };
            if (scroll > navHeight + 50){
                navFixed.addClass("fixed-menu");
                navFixed.removeClass("nofixed");
            };

        });
    };

    // Owl Carousel-2
    $(".proj-slider-wrap").each(function(){

        var Slider = $(this).find(".proj-slider");
        Slider.owlCarousel({
            items : 1,
            nav : true,
            autoPlay: true,
            //autoplayTimeout : 10000,
            mouseDrag : false,
            //touchDrag : false,
            navText: '',
            loop : true,
            fluidSpeed : 1200,
            autoplaySpeed : 1200,
            navSpeed : 1200,
            dotsSpeed : 1200,
            dragEndSpeed : 1200,
            animateOut: 'fadeOut',
            //animateIn: 'fadeIn',
            //navContainer: $(this).find(".slider-nav"),
            // responsiveClass: true,
            // responsive: {
            // 	0: {
            // 		items: 1,
            // 		slideBy: 1,
            // 		autoWidth: false,
            // 		//animateOut: 'fadeOut',
            // 	},
            // 	767: {
            // 		items: 4,
            // 		slideBy: 1,
            // 		autoWidth: false,
            // 		//autoWidth: true,
            // 	},
            // },

        });
    });

});