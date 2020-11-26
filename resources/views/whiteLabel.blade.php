<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>

<!-- Star CSS and Javascript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

	<link rel="stylesheet" href="{{ asset('/css/'.$name.'/reset.css') }}" type="text/css" media="screen,projection">
	<link rel="stylesheet" href="{{ asset('/css/'.$name.'/estilos.css') }}" type="text/css" media="screen,projection">
<!-- end CSS and Javascript -->
</head>

<body>


<!-- Link to open the modal -->
<p><a href="#ex1" rel="modal:open">Open Modal</a></p>



<div class="box-header">
	<div class="header">
		<h1 class="logo-sitio"><a href="#" title="Conejox.com">{{ $name }}</a></h1>
		<div class="tit-webcams">Webcams</div>
				
		<div class="logo-cum"><a href="#" title="Cumlouder.com">Cumlouder.com</a></div>

		<div class="menu"> 
			<a href="#" title="Acceso a las Chicas en Directo">Acceso a las Chicas en Directo</a> <span>|</span>
			<a href="#" title="Acceso Miembros">Acceso Miembros</a> <span>|</span>
			<a href="#" title="Compra Créditos">Compra Créditos</a>
		</div>

		<div class="clear"></div>
	</div>
</div>
<!-- termina HEADER -->

<div class="listado-chicas">


    @foreach ( $webCamsData as $webcan)
        @php 
            $size= '';
            $thumb = $webcan['wbmerThumb2'];
        @endphp
        @if ($webcan['size']  == 'big') 
            @php 
                $size = 'chica-grande';
                $thumb = $webcan['wbmerThumb4'];
            @endphp
        @endif
            <div id="ex1" class="modal" style="max-width: 1100px !important;">
                <iframe  width="1000"height="680"src="{{$webcan['wbmerLink']}}"></iframe>
                <a href="#" rel="modal:close">Close</a>
            </div>

            <div class="chica {{ $size }}">
                <a class="link" href="#ex1" rel="modal:open"  title="">
                    <span class="thumb"><img src="{{$thumb}}" width="357" height="307" alt="" title="" /></span>
                    <span class="nombre-chica"> <span class="ico-online"></span> {{$webcan['wbmerNick']}}</span>
                    <span id="favorito" class="ico-favorito" ></span>
                </a>
            </div>
    @endforeach
	
	
	<div class="clear"></div>
	

</div>
<!-- termina LISTADO DE CHICAS -->

<div class="box-footer">
	<div class="menu"> 
		<a href="#" title="Acceso a las Chicas en Directo">Acceso a las Chicas en Directo</a> <span>|</span>
		<a href="#" title="Acceso Miembros">Acceso Miembros</a> <span>|</span>
		<a href="#" title="Compra Créditos">Compra Créditos</a>
	</div>
</div>
<!-- termina MENU FOOTER -->

<div class="box-copy">
	<div class="menu">
		<p>Copyright © WAMCash Spain Todos los derechos reservados <span>|</span> <a href="#" title="Webmasters">Webmasters</a> </p>
		<p>Contenido para adultos <span>|</span> Tienes que tener mas de 18 años para poder visitarlo. Todas las modelos de esta web son mayores de edad.</p>
	</div>	
</div>
<!-- termina COPY -->

<div class="box-data">
	<div class="menu">
		<a href="#" title="Soporte Epoch">Soporte Epoch</a> <span>|</span>
		<a href="#" title="18 U.S.C. 2257 Record-Keeping Requirements Compliance Statement">18 U.S.C. 2257 Record-Keeping Requirements Compliance Statement</a> <span>|</span>
		<a href="#" title="Contacto">Contacto</a> <span>|</span>
		<a href="#" title="Please visit Epoch.com, our authorized sales agent">Please visit Epoch.com, our authorized sales agent</a>
	</div>
</div>
<!-- termina DATA -->

</body>
</html>