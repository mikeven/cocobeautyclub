<?php
  /* --------------------------------------------------------- */
  /* CBC - Funciones para envíos de email */
  /* --------------------------------------------------------- */
  /* --------------------------------------------------------- */
  function obtenerCabecerasMensaje(){
    //Devuelve las cabecera 
    $email_from = "reservaciones@cocobeautyclub.com";
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $cabeceras .= "From: Coco Beauty Club <$email_from>";

    return $cabeceras;
  }
  /* --------------------------------------------------------- */
  function obtenerPlantillaMensaje( $accion ){
    //Devuelve la plantilla html de acuerdo al mensaje a ser enviado
    $archivos = array(
      "nueva_reservacion"           => "nueva_reservacion.html",
      "actualizacion_reservacion"   => "actualizacion_reservacion.html",
      "cancelacion_reservacion"     => "cancelacion_reservacion.html",
      "recordatorio_actividad"      => "recordatorio_actividad.html"
    );

    $archivo = $archivos[$accion];
    $url_dir = "../fn/mailing/";
    if( $accion == "recordatorio_actividad" ) $url_dir = "fn/mailing/";
    return file_get_contents( $url_dir.$archivo );
  }
  /* --------------------------------------------------------- */
  function mensajeNuevaReservacion( $plantilla, $datos ){
    //Llenado de mensaje con plantilla de nueva reservación
    $server = "http://cocobeautyclub.com/";
    $url_cancelacion = $server."cancelar-reservacion.php?token=".$datos["token"];
    
    $plantilla = str_replace( "{url_cancelacion}", $url_cancelacion, $plantilla );
    $plantilla = str_replace( "{nombre}", $datos["nombre"], $plantilla );
    $plantilla = str_replace( "{apellido}", $datos["apellido"], $plantilla );
    $plantilla = str_replace( "{actividad}", $datos["actividad"], $plantilla );
    $plantilla = str_replace( "{fecha_y_hora}", $datos["fecha"], $plantilla );
    
    return $plantilla;
  }
  /* --------------------------------------------------------- */
  function mensajeReservacionActualizada( $plantilla, $datos ){
    //Llenado de mensaje con plantilla de nueva reservación
    $server = "http://cocobeautyclub.com/";
    $url_cancelacion = $server."cancelar-reservacion.php?token=".$datos["token"];
    
    $plantilla = str_replace( "{url_cancelacion}", $url_cancelacion, $plantilla );
    $plantilla = str_replace( "{nombre}", $datos["nombre"], $plantilla );
    $plantilla = str_replace( "{actividad}", $datos["actividad"], $plantilla );
    $plantilla = str_replace( "{fecha_y_hora}", $datos["fecha"], $plantilla );
    
    return $plantilla;
  }
  /* --------------------------------------------------------- */
  function mensajeAccionReservacion( $plantilla, $datos ){
    //Llenado de mensaje con plantilla de reservación cancelada / recordatorio de asistencia
    
    $plantilla = str_replace( "{nombre}", $datos["nombre"], $plantilla );
    $plantilla = str_replace( "{actividad}", $datos["actividad"], $plantilla );
    $plantilla = str_replace( "{fecha_y_hora}", $datos["fecha"], $plantilla );
    
    return $plantilla;
  }
  /* --------------------------------------------------------- */
  function escribirMensaje( $tmensaje, $plantilla, $datos ){
    //Sustitución de elementos de la plantilla con los datos del mensaje
    
    if( $tmensaje == "nueva_reservacion" ){
      $sobre["asunto"] = "Reservación en Coco Beauty Club";
      $sobre["mensaje"] = mensajeNuevaReservacion( $plantilla, $datos );
    }

    if( $tmensaje == "actualizacion_reservacion" ){
      $sobre["asunto"] = "Nueva fecha de reservación en Coco Beauty Club";
      $sobre["mensaje"] = mensajeReservacionActualizada( $plantilla, $datos );
    }

    if( $tmensaje == "cancelacion_reservacion" ){
      $sobre["asunto"] = "Reservación cancelada";
      $sobre["mensaje"] = mensajeAccionReservacion( $plantilla, $datos );
    }

    if( $tmensaje == "recordatorio_actividad" ){
      $sobre["asunto"] = "Recuerda asistir a Coco Beauty Club";
      $sobre["mensaje"] = mensajeAccionReservacion( $plantilla, $datos );
    }

    return $sobre; 
  }
  /* --------------------------------------------------------- */
  function enviarMensajeEmail( $tipo_mensaje, $datos, $email_receiver ){
    //Construcción del mensaje para enviar por email
    
    $cabeceras = obtenerCabecerasMensaje();
    $plantilla = obtenerPlantillaMensaje( $tipo_mensaje );
    $envio = escribirMensaje( $tipo_mensaje, $plantilla, $datos );
    
    mail( $email_receiver, $envio["asunto"], $envio["mensaje"], $cabeceras );
  }
  /* --------------------------------------------------------- */
?>