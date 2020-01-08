var mobile = /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4)) == true;

if ($(window).width() <= 480) {
    $("[data-tabhide]").attr('aria-expanded',false);
    $("[data-tabhide] i").toggleClass('fas fa-minus fas fa-plus');
    $("[data-tabitemhide]").removeClass('show');
}


function toggleChevron(e)
{
    $el = $(e.target).prev()
        .find("i")
        .toggleClass('fas fa-minus fas fa-plus rotate rotate2');
    setTimeout(function(){
        $el.toggleClass('rotate2 rotate');
    },100);
}

function showMenu(e) {
    e.preventDefault();
    $('.menu').toggleClass('show');
    $('.menu-close').toggleClass('d-none');
    $('.menu-close-button').toggleClass('show');
    $('body').toggleClass('no-scroll');
};

// Get the navbar
var navbar = document.getElementById("menu-panel");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function scrollMenu() {

    var sidePanel = $('.side-panel');

    if (window.pageYOffset > sticky) {
        if (!navbar.classList.contains('scrolled')) {
            navbar.classList.add("scrolled");
            navbar.classList.add("header-shadow");
            $(navbar).parent('#menu').addClass('position-fixed w-100').css('z-index', 999);
            if (sidePanel && !mobile) {
                sidePanel.addClass('side-panel--scrolled');
            }
        }
    } else {
        if (navbar.classList.contains('scrolled')) {
            navbar.classList.remove("scrolled");
            $(navbar).parent('#menu').removeClass('position-fixed w-100').css('z-index', 999);
            if (sidePanel && !mobile) {
                sidePanel.removeClass('side-panel--scrolled');
            }
        }
    }
};


/************************************/
/* DOM ready */
/************************************/
$(document).ready(function () {


    $.nette.init();

    $.nette.ext('loading', {
        before: function () {

        },
        complete: function () {

        }
    });

    // Faster lightbox
    lightbox.option({
        'resizeDuration': 300,
        'fadeDuration': 300,
        'imageFadeDuration': 300,
        'albumLabel': '%1/%2'
    });

    LiveForm.setOptions({
        messageErrorPrefix: '&nbsp;<i class="fas fa-exclamation-circle"></i>&nbsp;',
        wait: 500
    });

    /* OWL CAROUSEL - standard */
    var owl = $('.owl-carousel').owlCarousel({
        items: 1,
        dots: false,
        margin: 0,
        nav: false,
        lazyLoad: true
    });

    $('.owl-prev').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owl.trigger('prev.owl.carousel', [300]);
    });

    $('.owl-next').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owl.trigger('next.owl.carousel', [300]);
    });

    // Change + to - in accordion
    $('.accordion').on('hide.bs.collapse', toggleChevron);
    $('.accordion').on('show.bs.collapse', toggleChevron);

    // Show menu
    $('.menu-toggler, .menu-close, .menu-close-button').click(function (evt) {
        showMenu(evt);
    });

    $('.menu-link').click(function () {
        var parentMenuItem = $(this).parent();

        parentMenuItem.toggleClass('active');
    });


    // Submenu
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');


        $(this).parents('.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
        });


        return false;
    });

    // // When the user scrolls the page, execute scrollMenu
    // window.onscroll = function() {scrollMenu()};

    // Open mobile DROPDOWN MENU
    var openedMenuDropdown = $('.menu-item.open');
    if (openedMenuDropdown.length && mobile) {
        openedMenuDropdown.addClass('show');

        var toggleItem = openedMenuDropdown.find('.dropdown-toggle');
        var secondaryMenu = openedMenuDropdown.find('.secondary-menu');

        toggleItem.addClass('show');
        toggleItem.attr('aria-expanded', 'true');
        secondaryMenu.addClass('show');
    }

    $('[data-redirect]').on('click', function () {
        var href = $(this).data('redirect');
        window.location.href = href;
    });
});