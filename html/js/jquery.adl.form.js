$(document).ready(function(){
		$('form').bind('reset submit',function(e){
			switch(e.type){
				case 'reset':
					$(this).find('p.input_error_message').fadeOut("fast",function(){
						$(this).parents('li').animate({'margin-bottom':'30px'},100).find('.error').removeClass('error');
						$(this).remove();
					});
					$(this).find(".notification").find(".close_notification").trigger("click");
					$("form#"+$(this).attr('id')+" input:not([type='submit'],[type='reset'])").each(function(){
						$(this).val('');
						span_legend($(this),'focusout');
					});
				break;
				case 'submit':
				break;
			}
		});

		function span_legend(element,event){
			var color = "#4285f4";
			if(element.hasClass("error")){color="#d50000";}
			switch(event){
				case 'focus':
					element.next('.legend').stop().css({'transform':"scale(.75) translateY(-30px)","color":color});
					break;
				case 'focusout':
					if(element.val()!==""){element.next('.legend').stop().css({'transform':"scale(.75) translateY(-30px)","color":color});}
					else{element.next('.legend').stop().css({'transform':"scale(1) translateY(0px)","color":"rgba(0,0,0,.6)"});}
					break;
			}
		}
		$(window).bind('resize',ajust_window);
		ajust_window();
		$('input:text,input:password,textarea,select').bind('focus focusout',function(e){
			span_legend($(this),e.type);
		});

		//Função para ajustar css da página conforme elementos dinamicos aparecem
		function ajust_window(){
			$('p.input_error_message').each(function(){
				var margin = $(this).css('height').replace('px','');
				$(this).parents('li').css('margin-bottom',(parseInt(margin)+20)+"px");
			});
		}
		//Fechar div de notificação
		$('.close_notification').on('click',function(){
			$(this).parents('.notification').animate({
				"height":"0px",
				"opacity":"0",
				"padding-top":"0",
				"padding-bottom":"0"
			},400,function(){
				$(this).remove();
			});
		});
		//Checkbox Selector
		$('span.checkbox').on('click',function(){
			if($(this).hasClass('check')){
				$(this).removeClass('check').prev('input:checkbox').attr('checked',false).parents('tr').removeClass('select');
			}else{
				$(this).addClass('check').prev('input:checkbox').attr('checked',true).parents('tr').addClass('select');
			}
		});
		//Table tr selector
		$('.mails table td:not(.options)').on('click',function(){
			if($(this).parent('tr').hasClass('select')){
				$(this).parent('tr').removeClass('select').find('input:checkbox').attr('checked',false).next('span.checkbox').removeClass('check');
			}else{
				$(this).parent('tr').addClass('select').find('input:checkbox').attr('checked',true).next('span.checkbox').addClass('check');
			}
		});
		//Favorite Selector
		$('span.favorite').on('click',function(){
			if($(this).hasClass('favorited')){
				$(this).removeClass('favorited');
			}else{
				$(this).addClass('favorited');
			}
		});
	});