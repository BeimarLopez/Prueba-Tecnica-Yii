<?php  

namespace app\models;  

use Yii;  
use yii\db\ActiveRecord;  

class Usuarios extends ActiveRecord  
{  
    public static function getDb()  
    {  
        return Yii::$app->db; // Devuelve la conexión a la base de datos configurada en la aplicación  
    }  

    public static function tableName()  
    {  
        return 'User'; // Nombre de la tabla en la base de datos  
    }  
    
    // Si deseas definir relaciones, reglas de validación o métodos adicionales, puedes hacerlo aquí.  
}