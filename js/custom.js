// $('.deposit').click(function(e){
//     e.preventDefault();
//    $.get('deposit',function(data){
//         $('#deposit').modal('show')
//              .find('#depositContent')
//              .html(data);
// });
// });
$('.adeposit').click(function(e){
     e.preventDefault();
      var baseUrl = $(this).attr('baseUrl');
    $.get(baseUrl+'/deposit/adeposit',function(data){
         $('#adeposit').modal('show')
              .find('#adepositContent')
              .html(data);
      });
 });