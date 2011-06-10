function lockload()
{
	var load_obj = new Array();
	var row_color;
	var employee = null;
	return{
	
		
		_add_load: function(loadid){
			load_obj.unshift(loadid);		
		},
		
		_build_existing_loads:function(){
			
			$('.locked-by-me').each(function(index){
				load_obj.unshift($(this).attr('load_id'));
			});
		},
		
		_checkloadstatus:function(data,_this){
			if(data['lock_status']==3)
			{
				thislockload._recheckbox(_this);
				alert('This load is locked by '+data['locked_by']+ '.');
			}
			return data['lock_status'];
		
			},

		_dispatch_load:function(){
				if(employee == null){
					alert('You must select a driver before you can dispatch loads');
				}
				else
				{
					
				}
			},
			
		_lockload: function(_this){
		
			if($(_this).is(':checked'))
			{$chkstatus = 1;}
			else
			{$chkstatus = 0;}
			
			$load_id = $(_this).attr('load_id');
			thislockload = this;
			$.post("/dispatch/lockload", { load_locked: $chkstatus, load_id: $load_id },
					   function(data) {
						status = thislockload._checkloadstatus(data,_this);
						if(status==1)
						{thislockload._add_load($load_id);}
						else if(status ==0)
						{thislockload._remove_load($load_id);}
							
					   },'json');
		},
	
		
		_recheckbox:function(_this){
			$(_this).attr({checked:'checked'});
		},
		
		_remove_load: function(loadid){
			for(i=0;i<load_obj.length;i++)
			{
				if(load_obj[i]== loadid)
				{load_obj.splice(i, 1);}
			}
			
		},
		
		_select_employee: function(_this){
			
			employee = $(_this).attr('emp_id');
			this._reset_employee_table_color(_this);

			$(_this).closest('tr').css('background-color', '#306754');
			$(_this).closest('tr').css('color', '#ffffff');
		},
		
		_reset_employee_table_color: function(_this){
			$(_this).closest('tbody').children('tr:even').css('background-color', '#cef6e3');
			$(_this).closest('tbody').children('tr:odd').css('background-color', '#ffffff');
			$(_this).closest('tbody').children('tr').css('color', '#444444');

		}
	};
}