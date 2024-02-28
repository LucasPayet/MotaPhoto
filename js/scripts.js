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
                        // console.log('a response');
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

    var filtreCat = $('#Filtre_Catégories');
    var filtreFormat = $('#Filtre_Formats');
    var filtreDate = $('#Filtre_Date');

    var $filterBtn = $('.filter-me');

    var filterData = {
            'action' : 'filterAlbum',
            'cat' : 'all',
            'format': 'all',
            'year' : 'all',
            'post_type' : 'album'
        };

    $filterBtn.on('click', function(){
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
                        // console.log(response);
                        $container.html(response);
                        // console.log(response)
                    } else {
                        console.log('no response');
                        $container.html('<article class="relativ font-SpaceMono"><p>Aucune photo ne correspond au filtre !</p></article>');
                        $loadmoreButton.hide(); // Hide the button if no more posts
                    }
                }
            });
        }
            
    });

    
});