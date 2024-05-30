jQuery(document).ready(function($){
    $(".contact_btn").click(function(){
        $('.contactForm').toggleClass('hide');
    });

    $("#ContactRef").click(function(){
        $('.contactForm').toggleClass('hide');
        var ref = $("#ref").html().replace("Référence : ", "").toUpperCase();
        $("input#reference").val(ref);
    });

    $(document).click(function(e) {
        var contactForm = $('.contactForm');
        if (e.target === contactForm[0]) {
            contactForm.toggleClass('hide');
            $("input#reference").val("");
        }
    });
});


//Dropdown
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function dp_menu_zIndex() {
    sleep(500).then(() => {
        dp_menu.forEach(function(dp_menu) {
            dp_menu.style.zIndex = "-1";
        });
    });
}
dp_menu = document.querySelectorAll('.dropdown-menu');
// Get all the dropdown from document
document.querySelectorAll('.dropdown-toggle').forEach(dropDownFunc);

// Dropdown Open and Close function
function dropDownFunc(dropDown) {
    if(dropDown.classList.contains('click-dropdown') === true){
        dropDown.addEventListener('click', function (e) {
            e.preventDefault();        
    
            if (this.nextElementSibling.classList.contains('dropdown-active') === true) {
                // Close the clicked dropdown

                this.parentElement.classList.remove('dropdown-open');
                this.nextElementSibling.classList.remove('dropdown-active');
                dp_menu_zIndex()
            } else {
                dp_menu.forEach(function(dp_menu) {
                    dp_menu.style.zIndex = "10";
                });

                // Close the opend dropdown
                closeDropdown();
    
                // add the open and active class(Opening the DropDown)
                this.parentElement.classList.add('dropdown-open');
                this.nextElementSibling.classList.add('dropdown-active');
            }
        });
    }
};


// Listen to the doc click
window.addEventListener('click', function (e) {

    // Close the menu if click happen outside menu
    if (e.target.closest('.dropdown-container') === null) {
        // Close the opend dropdown
        dp_menu_zIndex()
        closeDropdown();
    }

});


// Close the openend Dropdowns
function closeDropdown() { 
    // remove the open and active class from other opened Dropdown (Closing the opend DropDown)
    document.querySelectorAll('.dropdown-container').forEach(function (container) { 
        container.classList.remove('dropdown-open')
    });

    document.querySelectorAll('.dropdown-menu').forEach(function (menu) { 
        menu.classList.remove('dropdown-active');
    });
}


jQuery(function($){

    //burger menu
    var burger = $('.burger');
    var menu = $('.menu');

    // Check window width on resize
    $(window).resize(function() {
        if ($(window).width() >= 900) {
            $("html").css("--anim-speed", "0s");
        }
    });

    burger.on('click', function (){
        burger.toggleClass('active');
        menu.toggleClass('nav-position');
        $("html").css("--anim-speed", "1s");
    })
    //end burger menu

    //load more button
    var page = 2;
    var loading = false;
    var $loadmoreButton = $('#load-more-button');
    var $container = $('#post-container');

    $loadmoreButton.on('click', function(){
        if(!loading){
            loading = true;
            var data = {
                'action': 'loadmore',
                'page': page,
                'post_type': 'album',
            };

            $.ajax({
                url: loadmore_params.ajaxurl,
                data: data,
                type: 'POST',
                success:function(response){
                    if(response){
                        $container.append(response);
                        page++;
                        loading = false;
                        // lightboxHandler();
                    } else {
                        console.log('no response');
                        loading = false;
                        $loadmoreButton.hide(); // Hide the button if no more posts
                    }
                }
            });
        }
    });
    //end load more

    //filter
    var filtreCat = $('#Filtre_Catégories');
    var filtreFormat = $('#Filtre_Formats');
    var filtreDate = $('#Filtre_Date');

    var filterBtn = $('.filter-me');

    var filterData = {
            'action' : 'filterAlbum',
            'cat' : 'all',
            'format': 'all',
            'year' : 'all',
            'post_type' : 'album'
        };

    filterBtn.on('click', function(){
        $loadmoreButton.hide();
        var valide = false;

        if ($(this).data('cat') !== undefined && $(this).data('cat') !== 'all') {
            var catData = $(this).data('cat');
            filterData.cat = catData;
            filtreCat.text(catData);
            valide = true;
        } else if ($(this).data('cat') !== undefined) {
            filterData.cat = 'all';
            filtreCat.text("CATÉGORIES");
            valide = true;
        }

        if ($(this).data('format') !== undefined && $(this).data('format') !== 'all') {
            var formatData = $(this).data('format');
            filterData.format = formatData;
            filtreFormat.text(formatData);
            valide = true;
        }else if ($(this).data('format') !== undefined) {
            filterData.format = 'all';
            filtreFormat.text("FORMATS");
            valide = true;
        }

        if ($(this).data('year') !== undefined && $(this).data('year') !== 'all') {
            var dateData = $(this).data('year');
            filterData.year = dateData;
            filtreDate.text(dateData);
            valide = true;
        }else if ($(this).data('year') !== undefined) {
            filterData.year = 'all';
            filtreDate.text("TRIER PAR");
            valide = true;
        }
        
        if (valide){
            $.ajax({
                url: loadmore_params.ajaxurl,
                data: filterData,
                type: 'POST',
                dataType : 'html',
                success:function(response){
                    if(response){
                        $container.html(response);
                        dp_menu_zIndex()
                        closeDropdown()
                        // lightboxHandler();
                    } else {
                        console.log('no response');
                        $container.html('<article class="relativ font-SpaceMono"><p>Aucune photo ne correspond au filtre !</p></article>');
                
                    }
                }
            });
            $(this).closest('ul').find('.filter-me').removeClass('filter-click');
            $(this).addClass('filter-click');
        }
            
    });
    //end filter

    //overlay
    //lb > lightbox
    var lightbox_btn = $('.lightbox_btn'); //overlay lightbox btn
    var lightbox = $('#lightbox'); //lightbox container
    var lb_prev = $('.Lb-prev-btn');
    var lb_next = $('.Lb-next-btn');
    var lightboxImage = $('#lightboxImage'); //lightbox img
    var lightbox_off = true;
    var current_postid;

    const spanRef = $('#LbRef');
    const spanCat = $('#LbCat');

    var nextImageId;
    var prevImageId;

    function lightbox_ajax(postid){
        var lightbox_data = {
            'action' : 'getlightbox',
            'postID' : postid,
        };

        $.ajax({
            url: loadmore_params.ajaxurl,
            data: lightbox_data,
            type: 'POST',
            dataType : 'json',
            success:function(response){
                if(response){
                    lightboxImage.attr('src', response.image);
                    nextImageId = response.nextlink;
                    prevImageId = response.prevlink;
                    spanRef.html(response.ref);
                    spanCat.html(response.cat);
                    if (lightbox_off){
                        lightbox.toggleClass('lightbox-none');
                        lightbox_off = false;
                        return;
                    };
                } else {
                    console.log('no response');
                    return;
                }
            }
        });
    }
    
    lightbox_btn.on('click',function(){
        current_postid = $(this).data('postid');
        lightbox_ajax(current_postid);
    });
    
    lb_prev.on('click', function(){
        current_postid = prevImageId;
        lightbox_ajax(current_postid);
    });
    lb_next.on('click', function(){
        current_postid = nextImageId;
        lightbox_ajax(current_postid);
    });

    var lightbox_close = $('#Lb-close');
    lightbox_close.on('click', function(){
        lightbox.toggleClass('lightbox-none');
        lightbox_off = true;
    })
    //end overlay
});