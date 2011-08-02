function driverinfo()
{
	var load_obj={};
	var postdata = new Array();
	
	return{
	
	_insert_time:function(){
		  now = new Date();
		  hours = now.getHours();
		  min = now.getMinutes();
		  sec = now.getSeconds();


		    if (min <= 9) {
		      min = "0" + min;
		    }
		    if (sec <= 9) {
		      sec = "0" + sec;
		    }
		    if (hours > 12) {
		      hours = hours - 12;
		      merridan = "PM";
		    } else {
		      hours = hours;
		      add = "AM";
		    }
		    if (hours == 12) {
		    	merridan = "PM";
		    }
		    if (hours == 00) {
		      hours = "12";
		    }
		return hours +':' + min + ' ' + merridan ;
	},
	
	_update_driver_info:function(elem){
		
		$(elem).each(function(index){
			load_obj={};

			load_obj.load_id = $(this).find('.load-id').attr('data');
			if($(this).find('.bol').length){
				load_obj.bill_of_lading = $(this).find('.bol').val();
			}
			if($(this).find('.net-gallons').length){
				load_obj.net_gallons = $(this).find('.net-gallons').val();
			}
			if($(this).find('.delivery-date').length && $(this).find('.delivery-time').length){
				load_obj.delivery_date = $(this).find('.delivery-date').val()+ ' '+ $(this).find('.delivery-time').val();
			}
			
			postdata[index]=load_obj;
			});
		this._post_driver_info()
	},
	
	_post_driver_info:function(){
		$.post('/dispatch/updatedriverload/',{load_data:postdata},function(data){
				
		},'html');
	}
	
	
	//endreturn
	}
	
	
}