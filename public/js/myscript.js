$(document).ready(function(){
  $(".alert-info").delay(3000).fadeOut("fast");
  var $list_action = $('.itemactions');
  $list_action.find('#submit').click(function(){
    if(!confirm('Are you sure?'))
    {
      return false;
    }
    var ids = new Array();
    $('[name="id[]"]:checked').each(function(){
      ids.push($(this).val());
    });
    if(!ids.length) return false;

    var url = $(this).attr('url');
    $.ajax({
      url: url,
      type: 'POST',
      data: {'ids' : ids},
      success: function()
      {
        $(ids).each(function(id,val){
          $('tr.row_'+val).fadeOut();
        });
      }
    })
    return false;

  });
});