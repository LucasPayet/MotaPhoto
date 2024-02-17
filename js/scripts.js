const contactbtns = document.querySelectorAll('.contact_btn');
const contactForm = document.querySelector('.contactForm');
const modale = document.querySelector('.contact-box')
contactbtns.forEach(contactbtn => {
    contactbtn.addEventListener('click', () => {
        contactForm.classList.toggle('hide');
    })
});

window.addEventListener('click', (e) => {
    if (e.target == contactForm){
        console.log(e);
        contactForm.classList.toggle('hide');
    }
})

jQuery(document).ready(function($){
    $("#ContactRef").click(function(){
        $('.contactForm').toggleClass('hide');
        var ref = $("#ref").html().replace("Référence : ", "").toUpperCase();
        $("input#reference").val(ref);
    });
});


//Dropdown
// Get all the dropdown from document
document.querySelectorAll('.dropdown-toggle').forEach(dropDownFunc);

// Dropdown Open and Close function
function dropDownFunc(dropDown) {
    console.log(dropDown.classList.contains('click-dropdown'));

    if(dropDown.classList.contains('click-dropdown') === true){
        dropDown.addEventListener('click', function (e) {
            e.preventDefault();        
    
            if (this.nextElementSibling.classList.contains('dropdown-active') === true) {
                // Close the clicked dropdown
                this.parentElement.classList.remove('dropdown-open');
                this.nextElementSibling.classList.remove('dropdown-active');
    
            } else {
                // Close the opend dropdown
                closeDropdown();
    
                // add the open and active class(Opening the DropDown)
                this.parentElement.classList.add('dropdown-open');
                this.nextElementSibling.classList.add('dropdown-active');
            }
        });
    }

    if(dropDown.classList.contains('hover-dropdown') === true){

        dropDown.onmouseover  =  dropDown.onmouseout = dropdownHover;

        function dropdownHover(e){
            if(e.type == 'mouseover'){
                // Close the opend dropdown
                closeDropdown();

                // add the open and active class(Opening the DropDown)
                this.parentElement.classList.add('dropdown-open');
                this.nextElementSibling.classList.add('dropdown-active');
                
            }

            // if(e.type == 'mouseout'){
            //     // close the dropdown after user leave the list
            //     e.target.nextElementSibling.onmouseleave = closeDropdown;
            // }
        }
    }

};


// Listen to the doc click
window.addEventListener('click', function (e) {

    // Close the menu if click happen outside menu
    if (e.target.closest('.dropdown-container') === null) {
        // Close the opend dropdown
        closeDropdown();
    }

});


// Close the openend Dropdowns
function closeDropdown() { 
    console.log('run');
    
    // remove the open and active class from other opened Dropdown (Closing the opend DropDown)
    document.querySelectorAll('.dropdown-container').forEach(function (container) { 
        container.classList.remove('dropdown-open')
    });

    document.querySelectorAll('.dropdown-menu').forEach(function (menu) { 
        menu.classList.remove('dropdown-active');
    });
}

// close the dropdown on mouse out from the dropdown list

jQuery(function($){
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
                        console.log('a response');
                        $container.append(response);
                        page++;
                        loading = false;
                    } else {
                        console.log('no response');
                        loading = false;
                        $loadmoreButton.hide(); // Hide the button if no more posts
                    }
                }
            });
        }
    });

    var $filterBtn = $('.filter-me');

    var filterData = {
        'action' : 'filterAlbum',
        'cat' : 'all',
        'format': 'all',
        'year' : 'all',
        'post_type' : 'album'
    };

    $filterBtn.on('click', function(){
        var valide = false;

        if ($(this).data('cat') !== undefined && $(this).data('cat') !== 'all') {
            filterData.cat = $(this).data('cat');
            valide = true;
        }
        // filterData.cat = 'concert';
        if ($(this).data('format') !== undefined && $(this).data('format') !== 'all') {
            filterData.format = $(this).data('format');
            valide = true;
        }
        if ($(this).data('year') !== undefined && $(this).data('year') !== 'all') {
            filterData.year = $(this).data('year');
            valide = true;
        }
        // theYear = $filterBtn.data('year');$(this).data('cat')
        // filterData.year = $(this).data('year');
        console.log(filterData);
        if (valide){
            $.ajax({
                url: loadmore_params.ajaxurl,
                data: filterData,
                type: 'POST',
                dataType : 'html',
                success:function(response){
                    if(response){
                        $container.html(response);
                        // console.log(response)
                    } else {
                        console.log('no response');
                        $loadmoreButton.hide(); // Hide the button if no more posts
                    }
                }
            });
        }
            
    });

    
});