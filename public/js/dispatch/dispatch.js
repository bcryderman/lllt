function lockload()
{
	var loads_selected = new Array();
	var row_color;
	var employee = {'emp_id': null,'compartments':null,'delayed_dispatch':0,'load_ids':null,'multi_dispatch':0,'name':null,'html':null};
	var dispatch_obj = {'load_id':null,'delayed_dispatch':0,'emp_id':null,'dispatch_order':0,'bill-rate':0,'fuel_surcharge':0};
	return{
	
		
		_add_load: function(loadid){
			loads_selected.unshift(loadid);
		},
		
		_remove_load: function(loadid){
			for(i=0;i<loads_selected.length;i++)
			{
				if(loads_selected[i]== loadid)
				{loads_selected.splice(i, 1);}
			}
		},
		
		_loads_selected:function(){
			
		},
		
		_build_existing_loads:function(){
			
			$('.locked-by-me').each(function(index){
				loads_selected.unshift($(this).attr('load_id'));
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
						//html[i]=$(this).closest('tr').html();
					});
					
					employee.load_ids = ids;
					//employee.html = html;
					
					if(employee.compartments>1){
						this._multiple_compartments();
					}
					else{
						//this._delayed_dispatch();
						this._dispatch_load();
					}
				}
			},
			
		_dispatch_load:function(){
				thislockload = this;
				$.post("/dispatch/dispatchmodal",employee,
				function(data){
					$('#dispatch-modal').html(data);
					
					$( "#dispatch-modal" ).dialog({
						resizable: false,
						title:'Dispatch for ' + employee.name,
						height:300,
						width:800,
						modal: true,
						buttons: {
							'Cancel': function() {
							
								$( this ).dialog( "close" );
								//employee.delayed_dispatch = 0;
								//thislockload._dispatch_load();
								
							},
							'DISPATCH': function() {
								//$( this ).dialog( "close" );
								thislockload._perform_dispatch();
								//window.location.reload();
								//employee.delayed_dispatch = 1;
								//thislockload._dispatch_load();
							}
						}
					});
					
					
		},'html');
			},
			
		_delayed_dispatch:function(){

				$('#dispatch-modal').html('<div id="delayed-dispatch">Do you want to do delayed dispatch?</div>');
				thislockload = this;
				$( "#dispatch-modal" ).dialog({
					resizable: false,
					height:200,
					width:100,
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
				$('#dispatch-modal').html('<div id="multi-container">'+employee.name+' has multiple compartments.<br> Do you want to dispatch to multiple compartments?</div>');

				thislockload = this;
				$( "#dispatch-modal" ).dialog({
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
							
							var myObject = eval('(' + $(_this).attr('data') + ')');
							//console.log(myObject);
							
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
		

		
		_select_employee: function(_this){
			
			employee.emp_id = $(_this).attr('emp_id');
			employee.compartments = $(_this).attr('compartments');
			employee.name = $(_this).attr('emp_name');
			
			this._reset_employee_table_color(_this);

			$(_this).closest('tr').css('background-color', '#306754');
			$(_this).closest('tr').css('color', '#ffffff');
			console.log(employee);
		},
		
		_reset_employee_table_color: function(_this){
			$(_this).closest('tbody').children('tr:even').css('background-color', '#cef6e3');
			$(_this).closest('tbody').children('tr:odd').css('background-color', '#ffffff');
			$(_this).closest('tbody').children('tr').css('color', '#444444');

		},
		
		_dispatch_modal:function(){
			console.log($('.locked-by-me').parents('tr').length);
			$($('.locked-by-me').parents('tr')).clone().appendTo('#disp-modal');
			$('<td class="disp-ordernm"></td>').appendTo('#disp-modal tr');
			$('<td class="disp-notes"><textarea class="disp-notes-input" rows="1" cols="7" class="notes"></textarea></td>').appendTo('#disp-modal tr');
			
			//$('.bill-rate').appendTo($('.disp-billrate'));
			//$('.fuel-surcharge').appendTo($('.disp-fuelsur'));

				$('.dispatch-order').appendTo($('.disp-ordernm'));
			
			$('#disp-modal tr input').unbind('click');
			$('#disp-modal tr .disp-load-select input').removeClass('load-locked').addClass('delayed-dispatch').attr('checked',false);
			$('#disp-modal tr .disp-load-driver,#disp-modal tr .disp-load-delivered').hide();
			$('#disp-modal tr .disp-order-number').each(function(index){
				//console.log($(this).html());
			});
			
			if($('#disp-modal tr').length > 1){
				$('.delayed-dispatch').attr('checked','checked');
				}
			else
			{$('#disp-modal tr #disp-load-select').hide();}
		},
		
		_perform_dispatch:function(){
			dispatcharr= new Array();
			$('#disp-modal tr').each(function(index){
				if($(this).find('.delayed-dispatch').is(':checked'))
				{
					delayed = 1;
				}
				else
				{
					delayed = 0;
				}
				//Handle dispatch order. If no dispatch order is set then set the dispporder
				//variable to 99
				if($(this).find('.dispatch-order').val()>= 1)
				{disporder = $(this).find('.dispatch-order').val();}
				else
				{disporder = 99;}
				
				dispatcharr[index]={order_number:loadobj[$(this).find('.locked-by-me').attr('load_id')].order_number,
									delayed_dispatch:delayed,
									bill_rate:$(this).find('.bill-rate').val(),
									fuel_surcharge:$(this).find('.fuel-surcharge').val(),
									driver_id:employee.emp_id,
									compartments:employee.compartments,
									dispatch_order:disporder,
									load_id:$(this).find('.locked-by-me').attr('load_id'),
									notes:$(this).find('.disp-notes-input').val()};

				
			});
			
			//sort loads by dispatch order
			dispatcharr.sort(function(a, b){
				 return a.dispatch_order-b.dispatch_order
				});

			$.post('/dispatch/dispatch',{dispatch:dispatcharr},function(data){
				console.log(data);
			},'html');
		}

	};
}