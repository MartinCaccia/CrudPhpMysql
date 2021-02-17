﻿<?php 
    // Arrays para guardar mensajes y errores:

    session_start();

    # Incluimos la clase usuario
    require_once('conexion.php');

    class TraerIncidencias extends Conexion
    {
        public function traerIncidencia($inc_id)
        {	
            parent::conectar();

            $query =  'select inc.id, inc.tipo_incidencia,tip.descrip_inciden,
            inc.descrip_incidencia usuario_descripcion,
            concat(inc.nombre,"'.' '.'", inc.apellido) usuario,
            replace(tip.texto_resolucion,"'.'XXX'.'",concat(inc.nombre,"'.' '.'", inc.apellido)) texto_resolucion,
            inc.email
            from ywayqssx_MA.incidencias inc, ywayqssx_MA.tipinciden tip
            where id= '.$inc_id.'
            and tip.tipo_incidencia= inc.tipo_incidencia
            and estado= 0';

            $resEmp =parent::query($query);

            while($row = mysqli_fetch_array($resEmp))
            {
                //echo json_encode($row); 
                $id=$row['id'];
                $tipo_incidencia=$row['tipo_incidencia'];
                $descrip_inciden=$row['descrip_inciden'];
                $usuario_descripcion=$row['usuario_descripcion'];
                $usuario=$row['usuario'];
                $texto_resolucion=$row['texto_resolucion'];
                $email=$row['email'];

                $incidencia[] = array('id'=> $id, 'tipo_incidencia'=> $tipo_incidencia, 'descrip_inciden'=> $descrip_inciden, 'usuario_descripcion'=> $usuario_descripcion,
                    'usuario'=> $usuario,'texto_resolucion'=>$texto_resolucion,'email'=>$email);
            }

            if (!empty($incidencia)) 
            {
                //mysqli_free_result($resEmp);
                //include('cerrar_conexion.php');
                //Creamos el JSON
                $json_string = json_encode($incidencia);
                echo $json_string;
            }
            else 
            {
                $incidencia = [];

                //mysqli_free_result($resEmp);
                //include('cerrar_conexion.php');
                $json_string = json_encode($incidencia);
                echo $json_string;
            }	
            parent::cerrar();
		}
	}

    if (isset($_POST['traerIncidencia']))
	{
		$foo = new TraerIncidencias();

		$foo->traerIncidencia($_GET['inc_id']);
   	}
?>