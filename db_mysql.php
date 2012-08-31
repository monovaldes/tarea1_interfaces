<?php   

class DALQueryResult {  
      
  private $_results = array();  
  
  public function __construct(){}  
  
  public function __set($var,$val){  
    $this->_results[$var] = $val;  
  }  
  
  public function __get($var){    
    if (isset($this->_results[$var])){  
      return $this->_results[$var];  
    }  
    else{  
      return null;  
    }  
  }  
}  
  
class DAL {  
  
  public function __construct(){}  
    
  public function listado_localidades(){  
    $sql = "SELECT * FROM Localidad, Comuna, Region WHERE Localidad.id_comuna = Comuna.id_comuna AND Comuna.Num_region = Region.Num_region";
    return $this->query($sql);  
  }

  public function obtener_destino($dest)
  {
    $sql = "SELECT * FROM Localidad WHERE Nombre_localidad = '".$dest."'";
    return $this->query($sql);
  } 
  public function obtener_establecimiento($dest)
  {
    $sql = "SELECT * FROM Establecimiento WHERE Nombre = '".$dest."'";
    return $this->query($sql);
  } 

  public function establecimientos(){  
    $sql = "SELECT Establecimiento.Id_establecimiento ID, Localidad.Nombre_localidad Ubicacion, Establecimiento.nombre Nombre, 
            Establecimiento.Telefono Telefono,Establecimiento.URL URL,Establecimiento.Categoria Categoria ,
            Tipo_establecimiento.Nombre_tipo Establecimiento_tipo,Comida.especialidad Comda_especialidad, 
            Alojamiento.Tipo Alojamiento_tipo,Alojamiento.Cantidad Alojamiento_cantidad,
            Alojamiento.precio Alojamiento_precio,Esparcimiento.Tipo Esparcimiento_tipo, 
            Esparcimiento.Cantidad Esparcimiento_cantidad, Establecimiento.Latitud Latitud,
            Establecimiento.Longitud Longitud
            FROM Establecimiento
            LEFT JOIN Localidad ON Localidad.Id_localidad = Establecimiento.Id_localidad
            LEFT JOIN Comida ON Comida.Id_establecimiento = Establecimiento.Id_establecimiento
            LEFT JOIN Alojamiento ON Alojamiento.Id_establecimiento = Establecimiento.Id_establecimiento
            LEFT JOIN Esparcimiento ON Esparcimiento.Id_establecimiento = Establecimiento.Id_establecimiento
            LEFT JOIN Tipo_establecimiento ON Establecimiento.Id_tipo = Tipo_establecimiento.Id_tipo";
    return $this->query($sql);  
  } 
    
  private function dbconnect() {  
    $conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)  
        or die ("<br/>Could not connect to MySQL server");  
          
    mysql_select_db(DB_DB,$conn)  
        or die ("<br/>Could not select the indicated database");    
    return $conn;  
  }  
    
  private function query($sql){  
  
    $this->dbconnect();  
    mysql_query("SET NAMES 'utf8'");
    $res = mysql_query($sql);  
  
    if ($res){  
      if (strpos($sql,'SELECT') === false){  
        return true;  
      }  
    }  
    else{  
      if (strpos($sql,'SELECT') === false){  
        return false;  
      }  
      else{  
        return null;  
      }  
    }  
  
    $results = array();  
  
    while ($row = mysql_fetch_array($res)){  
  
      $result = new DALQueryResult();  
  
      foreach ($row as $k=>$v){  
        $result->$k = $v;  
      }  
  
      $results[] = $result;  
    }  
    return $results;          
  }    
}  
  
?>  