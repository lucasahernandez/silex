$(document).on('pagebeforeshow', '#index', function(){ 
    ajax.ajaxCall("handler.php", true);
});
 
$(document).on('click', '#user-list li', function(){ 
    ajax.ajaxCall("handler.php/" + ($(this).data('listid')), false);
});
 
var ajax = { 
    parseJSON:function(result){ 
        var obj = jQuery.parseJSON(result);
        $('#user-list').empty();        
        $.each(obj, function(key,row) {
            $('#user-list').append('<li data-listid="' + row.id + '"><a href="" data-id="' + row.id + '"><h3>' + row.user + '</h3><p>' + row.timestamp + '</p></a></li>');       
        });
        $('#user-list').listview('refresh');        
    },
    parseJSONDetails:function(result){ 
        var obj = jQuery.parseJSON(result);     
        $('#personal-data').empty();
        $('#personal-data').append('<li>User: '+obj.user+'</li>');
        $('#personal-data').append('<li>Customer: '+obj.customer+'</li>');           
	$('#personal-data').append('<li>Context: '+obj.context+'</li>');
        $('#personal-data').append('<li>TimeStamp: '+obj.timestamp+'</li>');
        $('#personal-data').listview().listview('refresh'); 
        $.mobile.changePage( "#second");
    },
    ajaxCall: function(url, initialize) {
        $.ajax({
            url: url,
            async: 'true',
            success: function(result) {
                if (initialize) {
                    ajax.parseJSON(result);
                } else {
                    ajax.parseJSONDetails(result);
                }
            },
            error: function(request, error) {
                alert('Network error has occurred, please try again!');
            }
        });
    }
} 
