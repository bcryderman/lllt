function lockload()
{
	var load_obj = new Array();
	var row_color;
	var employee = {'emp_id': null,'compartments':null,'delayed_dispatch':0,'load_ids':null,'multi_dispatch':0,'name':null,'html':null};
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

		_start_dispatch_load:function(){
				if(employee.emp_id == null){
					alert('You must select a driver before you can dispatch loads');
				}
				else
				{
					var ids = new Array();
					var html = new Array();
					$('.locked-by-me').each(function(i){
						ids[i]= $(this).attr('load_id');
						html[i]=$(this).closest('tr').html();
					});
					
					employee.load_ids = ids;
					employee.html = html;
					
					if(employee.compartments>1){
						this._multiple_compartments();
					}
					else{
						this._delayed_dispatch();
					}
					
					
					
				}
			},
			
		_dispatch_load:function(){
				
				$.post("/dispatch/dispatch",employee,
				function(data){
					$('.emp-container').append('<div id="dispatch-modal">'+data+'</div>');
					
					$( "#dispatch-modal" ).dialog({
						resizable: false,
						height:300,
						width:500,
						modal: true,
						buttons: {
							'No': function() {
								$( this ).dialog( "close" );
								//employee.delayed_dispatch = 0;
								//thislockload._dispatch_load();
							},
							'Yes': function() {
								$( this ).dialog( "close" );
								//employee.delayed_dispatch = 1;
								//thislockload._dispatch_load();
							}
						}
					});
					
					
		},'html');
			},
			
		_delayed_dispatch:function(){

				$('.emp-container').append('<div id="delayed-dispatch">Do you want to do delayed dispatch?</div>');
				thislockload = this;
				$( "#delayed-dispatch" ).dialog({
					resizable: false,
					height:200,
					modal: true,
					buttons: {
						'No': function() {
							$( this ).dialog( "close" );
							employee.delayed_dispatch = 0;
							thislockload._dispatch_load();
						},
						'Yes': function() {
							$( this ).dialog( "close" );
							employee.delayed_dispatch = 1;
							thislockload._dispatch_load();
						}
					}
				});
			},
			
		_multiple_compartments:function(){
				
				$('.emp-container').append('<div id="multi-container">'+employee.name+' has multiple compartments.<br> Do you want to dispatch to multiple compartments?</div>')
				thislockload = this;
				$( "#multi-container" ).dialog({
					resizable: false,
					height:200,
					modal: true,
					buttons: {
						'No': function() {
							$( this ).dialog( "close" );
							employee.multi_dispatch = 0;
							thislockload._delayed_dispatch(employee);
						},
						'Yes': function() {
							$( this ).dialog( "close" );
							employee.multi_dispatch = 1;
							thislockload._delayed_dispatch(employee);
						}
					}
				});
			
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
						{
							thislockload._add_load($load_id);
							$(_this).addClass('locked-by-me');
						}
						else if(status ==0)
						{
							thislockload._remove_load($load_id);
							$(_this).removeClass('locked-by-me');
						}
							
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
			
			employee = {'emp_id':$(_this).attr('emp_id'),'compartments':$(_this).attr('compartments'),'name':$(_this).attr('emp_name')};
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