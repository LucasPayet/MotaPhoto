// jQuery(function($){
//     var page = 2;
//     var loading = false;
//     var $loadmoreButton = $('#load-more-button');
//     var $container = $('#post-container');

//     $loadmoreButton.on('click', function(){
//         if(!loading){
//             loading = true;
//             var data = {
//                 'action': 'loadmore',
//                 'page': page,
//                 'post_type': 'album',
//             };

//             $.ajax({
//                 url: loadmore_params.ajaxurl,
//                 data: data,
//                 type: 'POST',
//                 success:function(response){
//                     if(response){
//                         console.log('a response');
//                         $container.append(response);
//                         page++;
//                         loading = false;
//                     } else {
//                         console.log('no response');
//                         loading = false;
//                         $loadmoreButton.hide(); // Hide the button if no more posts
//                     }
//                 }
//             });
//         }
//     });
// });