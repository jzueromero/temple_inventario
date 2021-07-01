<?php

require "conexion.php";

class db_funciones extends Conexion_pdo
{
    public function __construct()
    {
        parent::__construct();
    }

    public $empresa = 'MiTiendita - SV';
    public $ruta = 'http://localhost:8007/temple_inventario/';

    public function get_datos($consulta, $parametros)
    {

        $sentencia = $this->conexion_db->prepare($consulta);

        $sentencia->execute($parametros);
        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        $sentencia->closeCursor();
        return $resultado;
        $this->conexion_db = null;
    }

    public function get_dato_escalar($consulta, $parametros)
    {

        $sentencia = $this->conexion_db->prepare($consulta);

        $sentencia->execute($parametros);
        $resultado = $sentencia->fetchColumn();

        $sentencia->closeCursor();
        return $resultado;
        $this->conexion_db = null;
    }

    public function insert_datos($consulta, $parametros, $pagina)
    {
        try{
                $resultado=$this->conexion_db->prepare($consulta);
                $resultado->execute($parametros) ;

                $resultado->closeCursor();
                sleep(1);
                header('location:'.$pagina);

            }
            catch(Exception $e){
                die('Error: '. $e->GetMessage());
            }
            finally
            {
                $base = -1;
            }
    }

    public function insert_datos_2($consulta, $parametros)
    {
        try{
                $resultado=$this->conexion_db->prepare($consulta);
                $resultado->execute($parametros) ;

                $resultado->closeCursor();

            }
            catch(Exception $e){
                die('Error: '. $e->GetMessage());
            }
            finally
            {
                $base = -1;
            }
    }

    public function insert_historial($parametros)
    {
        try{
                $consulta = "INSERT INTO hist_historial
                            (hist_tabla, hist_descripcion, hist_usuario, hist_cod_usuario, hist_fecha)
                            VALUES(:tabla, :descripcion,  :usuario,:cod_usuario, CURRENT_TIMESTAMP);";
                $resultado=$this->conexion_db->prepare($consulta);
                $resultado->execute($parametros) ;

                $resultado->closeCursor();
            }
            catch(Exception $e){
                die('Error: '. $e->GetMessage());
            }
            finally
            {
                $base = -1;
            }
    }

    public function generar_token_transaccion($id_usuario, $usuario)
    {
        $codigo = trim($id_usuario);
        $nombre = trim($usuario);
        $fecha = new DateTime();

        return $codigo."-.-".$nombre."-.-".$fecha->format("d-m-Y H:i:s");
    }

    public function get_zona_horaria()
    {
        return ZONE_TIME;
    }


}

?>