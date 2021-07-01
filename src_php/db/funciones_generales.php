<?php
class funciones_generales
{
    static $dominio = "http://localhost:8007/delivery_app/";
    public function miget($get)
    {
        @$variable = $_GET[$get];
        return trim($variable);
    }

    public  $errores = [];
    
    public function mipost($post)
    {
        @$variable = $_POST[$post];
        return trim($variable);
    }

    public function caja_texto($id, $titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor = '')
    {
        $lectura = $habilitado == 0 ? ' readonly ' : '';
        $requerido = $requerido != 0 ? ' required ' : '';
        $text = "<div class='col-md-" . $columnas . "'>
            <div class='form-group'>
                <label for='" . $id . "'>" . $titulo . "</label>
                <input type='" . $tipo . "' class='form-control' id='" . $id . "' name='" . $id . "' value='" . $valor . "' placeholder='" . $placeholder . "' " . $lectura . " " . $requerido . ">
                <!-- <small id='' class='form-text text-muted'>Código de identificacion para <?php echo $titulo; ?></small> -->
            </div>
        </div>";

        echo $text;
    }

    public function lista_valores($id, $titulo, $columnas, $datos, $valor)
    {
        $seleccionado = "";
        echo "<div class='form-group col-md-" . $columnas . "'>
                    <label for='" . $titulo . "'>" . $titulo . "</label>
                    <select id='" . $id . "' name='" . $id . "' class='form-control'>
                        ";
        foreach ($datos as $key => $op) {
            $seleccionado = $op["v"] == $valor ? "selected='selected'" : " ";
            echo "<option value='" . $op["v"] . "' " . $seleccionado . ">" . $op["t"] . "</option>";

        }

        echo "</select>
                    </div>";

    }

    public function lista_query($id, $titulo, $columnas, $datos, $valor)
    {
        $seleccionado = "";
        echo "<div class='form-group col-md-" . $columnas . "'>
                    <label for='" . $titulo . "'>" . $titulo . "</label>
                    <select id='" . $id . "' name='" . $id . "' class='form-control'>
                        ";
        foreach ($datos as $item) {
            $seleccionado = $item["v"] == $valor ? "selected='selected'" : " ";
            echo "<option value='" . $item["v"] . "' " . $seleccionado . ">" . $item["t"] . "</option>";
        }
        echo "</select>
                    </div>";
    }

    public function mostrar_popup($success1warning2danger3info4, $mensaje)
    {
        $tipo = $success1warning2danger3info4;
        $mensaje = " " . $mensaje;
        $icono = "icon fa fa-check";
        //info, success, warning, error
        switch ($tipo) {
            case '1':
                $tipo = "success";
                $icono = "fa fa-check-circle";
                break;
            case '2':
                $tipo = "warning";
                $icono = "fa fa-exclamation-circle";
                break;
            case '3':
                $tipo = "danger";
                $icono = "fa fa-times-circle";
                break;
            default:
                $tipo = "info";
                $icono = "fa fa-info-circle";
                break;
        }

        $result = "    <div class='row text-left'>
        <div class='col-md-6 col-lg-4'>
            <div class='alert alert-$tipo alert-dismissable' id='flash-msg'>
                <button aria-hidden='true' data-dismiss='alert' class='close' type='button'>&nbsp;×&nbsp;</button>
            <h4><i class='$icono'></i>$mensaje</h4>
            </div>
            </div>
                <div class='col-md-6 col-sm-12 col-lg-8'></div>
            </div>
            <div class='clearfix'></div>
            ";



        return $result;
    }

    public function mostrar_consola($str)
    {
        echo "<script>console.log('" . $str . "')</script>";
    }

    public function mostrar_alert($str)
    {
        echo "<script>alert('" . $str . "')</script>";
    }

    public function validar_requerido(string $texto): bool
    {
        return !(trim($texto) == '');
    }

    public function validar_entero(string $numero): bool
    {
        return (filter_var($numero, FILTER_VALIDATE_INT) === false) ? false : true;
    }

    public function validar_longitud_cadena($texto, $longitud): bool
    {
        return strlen(trim($texto)) < $longitud ? false : true;
    }

    public function validar_email(string $texto): bool
    {
        return (filter_var($texto, FILTER_VALIDATE_EMAIL) === false) ? false : true;
    }

    public function validar_url(string $texto): bool
    {
        return (filter_var($texto, FILTER_VALIDATE_URL) === false) ? false : true;
    }

    public function validar_double(string $texto): bool
    {
        return ($texto = is_numeric($texto)) === false ? false : true;
    }
}
