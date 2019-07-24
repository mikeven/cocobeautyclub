<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Accesos a roles de usuario */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	
	function obtenerUsuarioLogin( $dbh, $email, $passw ){
		// Devuelve los datos del usuario que inicia sesión
		$data_u = NULL;
		$q = "select * from usuario where email = '$email' and password = '$passw'";
		
		$data 	= mysqli_query ( $dbh, $q );
		$nrows 	= mysqli_num_rows( $data );
		if( $nrows > 0 )
			$data_u = mysqli_fetch_array( $data );

		return $data_u;
	}
	/* --------------------------------------------------------- */
	function actualizarUltimoIngreso( $dbh, $idp ){
		// Actualiza la fecha de último inicio de sesión de un usuario
		$q = "update usuario set ultimo_ingreso = NOW() where id = $idp";
		
		$data = mysqli_query( $dbh, $q );
		return mysqli_affected_rows( $dbh );
	}
	/* --------------------------------------------------------- */
	function iniciarSesion( $data_u ){
		// Inicia la sesión de usuario
		session_start();
		
		$_SESSION["login"] 	= 1;	
		$_SESSION["user"] 	= $data_u;
	}
	/* --------------------------------------------------------- */
	function checkLogin( $dbh, $email, $passw ){
		// Verifica si un usuario existe y está habilitado para ingresar

		$data_login["valido"] = false;
		$data_u = NULL;
		$data_u = obtenerUsuarioLogin( $dbh, $email, $passw );

		if( $data_u != NULL ){
			$data_login["valido"] = true;
			$data_login["usuario"] = $data_u;
			iniciarSesion( $data_u );
		}
		
		return $data_login;
	}
	
	/* --------------------------------------------------------- */
	function checkSession(){
		// Redirecciona a la página de inicio de sesión en caso de no existir sesión de usuario
		if( isset( $_SESSION["user"] ) ){
			
		}else{
			echo "<script> window.location = 'index.php'</script>";		
		}
	}
	/* --------------------------------------------------------- */
	//Inicio de sesión (asinc)
	if( isset( $_POST["login"] ) ){ 
		// Invocación desde: js/fn-acceso.js
		include( "bd.php" );
	
		parse_str( $_POST["login"], $usuario );
		$usuario = escaparCampos( $dbh, $usuario );
		$login 	= checkLogin( $dbh, $usuario["email"], $usuario["password"] );
		
		if( $login["valido"] ){
			actualizarUltimoIngreso( $dbh, $login["usuario"]["id"] );
			$res["exito"] = 1;
			$res["mje"] = "Inicio de sesión exitosa";
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Email o contraseña incorrecta, verifique sus datos e intente nuevamente";
		}
		
		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	//Cierre de sesión
	if( isset( $_GET["logout"] ) ){
		
		unset( $_SESSION["login"] );
		unset( $_SESSION["user"] );
		echo "<script> window.location = 'index.php'</script>";		
	}
	/* --------------------------------------------------------- */
?>