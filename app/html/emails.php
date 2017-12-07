<!DOCTYPE html>
<html>
<head>
	<title>Webmail</title>
	<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
	<script type="text/javascript" src="js/jquery.adl.form.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<link rel="stylesheet" type="text/css" href="css/input.css">
	<link rel="stylesheet" type="text/css" href="css/mail.css">
	<script type="text/javascript">
		$(document).ready(function(){
			//Painel de pastas ajustavel
			$('.folders').resizable({
				handles:"e",
				containment:"body",
			    maxWidth: 700,
			    minWidth: 200,
			    resize:ajust
			});
			//Painel de leitura ajustavel
			$('.mails').resizable({
				handles:"s",
				containment:"body",
				minHeight:200,
			    resize:ajust
			});
			//Ajuste de tela na inicialização da pagina
			setTimeout(ajust,200);
			$(window).bind('resize load',ajust);
			//Selecionar emails para mover
			$('.mails tr').draggable({
				helper: "clone",
				containment:$('document'),
				appendTo: 'body',
				cursorAt: { top: 0, left: 0},
				start:function(){
					if(!$(this).hasClass('select')){
						$(this).find('td.subject').trigger('click');
					}
					var selects = '';
					var mails = "";
					$('.ui-draggable-dragging').css({'display':'none','top':'0 !important'});
					$('.mails tr:not(.ui-draggable-dragging)').each(function(){
						if($(this).hasClass('select')){
							selects = selects + $(this).attr('id')+',';
							mails = mails + "<p>"+$(this).find('td.subject').html()+"</p>";
						}
					});
					$('.ui-draggable-dragging').html("<td>"+selects+"</td>");
					$('div.cache_mail').html(mails);
				
				},
				drag:function(e){
					var heightBody = getHeight($('body'));
					var widthBody = getWidth($('body'));

					display = 'block';
					if(e.pageY>(heightBody-50) || e.pageX>(widthBody-50)){ display = "none";}
					
					$('div.cache_mail').css({
						'display':'block',
						'top': e.pageY-10,
    					'left': e.pageX+20,
    					'display':display
					});

				},
				stop:function(){
					$('div.cache_mail').html('').css('display','none');
				},
				
			});
			//Mover emails para outra caixa
			$('ul.folders li:not(.subfolder_content)').droppable({
		    	drop: function( event, ui ) {
		        	$(this).addClass('select');
		        	console.log(ui.helper.html());
		      	}
		    });
			//Abrir subpasta
			$('.subfolder_link').on('click',function(){
				if($(this).parent('li').hasClass('open')){
					$(this).parent('li').removeClass('open').next('li.subfolder_content').slideToggle('fast');
				}else{
					$(this).parent('li').addClass('open').next('li.subfolder_content').slideToggle('fast');
				}
			});

			//Pegar ocupação de height total de elemento
			function getHeight(e){
				return (parseInt(e.css('height').replace('px',''))+
			   		    parseInt(e.css('padding-top').replace('px',''))+
			    		parseInt(e.css('padding-bottom').replace('px',''))+
			    		parseInt(e.css('margin-bottom').replace('px',''))+
			    		parseInt(e.css('margin-top').replace('px','')));
			}
			//Pegar ocupação de width total de elemento
			function getWidth(e){
				return (parseInt(e.css('width').replace('px',''))+
			    		parseInt(e.css('padding-left').replace('px',''))+
			    		parseInt(e.css('padding-right').replace('px',''))+
			    		parseInt(e.css('margin-left').replace('px',''))+
			    		parseInt(e.css('margin-right').replace('px','')));
			}
			//Ajustar elementos conforme tamanho da tela
			function ajust(){
				var widthFolders = getWidth($('.folders'));
			    var widthBody = getWidth($('body'));

				var heightMenu = getHeight($('div.folders div.h1'));
				var heightHeader = getHeight($('header'));
				var heightBody = getHeight($('body'));
				var heightVisualEmail = getHeight($('.email'))+5;

				var heightContent = heightBody-(heightHeader+heightMenu);
			    
			    if($('.email').css('display')=="block"){
			    	$('.mails').resizable("option","maxHeight",(heightContent/100)*70).css("max-height",(heightContent/100)*70);
			    	$('.email').css("min-height",(heightContent/100)*30);
			    }else{
			    	$('.mails').resizable("option","maxHeight",(heightContent/100)*70).css("max-height","100%");
			    }


			    $('.emails').css('width',(widthBody-widthFolders+2)+"px");
			    $('.top-menu').css('height',getHeight($('div.folders div.h1')));
			    
			    heightFolders = heightBody-(getHeight($('.sendmail'))+getHeight($('div.folders div.h1'))+heightHeader)-26;
			    $('div.folders ul.folders').css('height',heightFolders);
			}
		});
	</script>
</head>
<body>
	<header>header</header>
		<div class="folders">
			<div class="h1"><h1>Webmail</h1></div>
			<a class="sendmail">Novo email</a>
			<ul class="folders">
				<!-- Loop de caixas de emails -->
				<li class="select"><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li class="subfolder">
					<span class="subfolder_link"></span>
					<a>Caixa de entrada</a>
				</li>
				<li class="subfolder_content">
					<ul>
						<li><a>Sub Caixa de entrada</a></li>
						<li class="subfolder">
							<span class="subfolder_link"></span>
							<a>Sub Caixa de entrada</a>
						</li>
						<li class="subfolder_content">
							<ul>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li><li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li><li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
								<li><a>Sub Sub caixa de entrada</a></li>
							</ul>
						</li>
						<li><a>Sub Caixa de entrada</a></li>
					</ul>
				</li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<li><a>Caixa de entrada</a></li>
				<!-- Loop de caixas de emails -->
			</ul>
			<div class="options">
				<ul>
					<li>1</li>
					<li>2</li>
				</ul>
			</div>
		</div>
		<div class="emails">
			<div class="top-menu">
				<ul>
					<li class="options">Opções</li>
					<li class="paginator">Páginação</li>
				</ul>
			</div>
			<div class="mails">
				<table>
					<!-- Loop de emails -->
					<tr class="new" id="1">
						<td class="options">
							<span class="new"></span>
							<input type="checkbox">
							<span class="checkbox" title="Selecionar e-mail"></span>
							<span class="favorite" title="Marcar como favorito"></span>
							<span class="annex" title="Com anexo"></span>
							<span class="priority" title="Está mensagem é de alta prioridade">!</span>
						</td>
						<td class="remetent" title="hennry.vb@gmail.com">hennry.vb@gmail.com</td>
						<td class="subject" title="Assunto de texto muito extenso 1234567893216549871">Assunto de texto muito extenso 1</td>
						<td title="1Mb">1 MB</td>
						<td title="Data e hora">Data e hora</td>
					</tr>
					<tr id="4">
						<td class="options">
							<span class="new"></span>
							<input type="checkbox">
							<span class="checkbox" title="Selecionar e-mail"></span>
							<span class="favorite" title="Marcar como favorito"></span>
						</td>
						<td class="remetent" title="hennry.vb@gmail.com">hennry.vb@gmail.com</td>
						<td class="subject" title="Assunto de texto muito extenso 1234567893216549871">Assunto de texto muito extenso 4</td>
						<td title="1Mb">1 MB</td>
						<td title="Data e hora">05/12/2017 - 09:55</td>
					</tr>
				</table>
				<!-- Loop de emails -->
			</div>
			<div class="email">
				Visualização dos emails
			</div>
		</div>
		<div class="cache_mail"></div>
</body>
</html>