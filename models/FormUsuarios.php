<?php  

namespace app\models;  

use Yii;  
use yii\base\Model;  

class FormUsuarios extends Model  
{  
    public $id;         // id del usuario  
    public $name;       // nombre del usuario  
    public $phone;      // número de teléfono del usuario  
    public $username;   // nombre de usuario único  
    public $email;      // correo electrónico  
    public $password;   // contraseña  

    public function rules()  
    {  
        return [  
            ['id', 'integer', 'message' => 'ID incorrecto'],  
            ['name', 'required', 'message' => 'Campo requerido'],  
            ['name', 'string', 'length' => [3, 100], 'message' => 'Mínimo 3 máximo 100 caracteres'],  
            ['name', 'match', 'pattern' => '/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/u', 'message' => 'Sólo se aceptan letras'],  

            ['phone', 'string', 'length' => [0, 15], 'message' => 'El número de teléfono no puede tener más de 15 caracteres'],  
            ['phone', 'match', 'pattern' => '/^[0-9]*$/', 'message' => 'Sólo se aceptan números'],  

            ['username', 'required', 'message' => 'Campo requerido'],  
            ['username', 'string', 'length' => [3, 50], 'message' => 'Mínimo 3 máximo 50 caracteres'],  
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Sólo se aceptan letras, números y guiones bajos'],  

            ['email', 'required', 'message' => 'Campo requerido'],  
            ['email', 'email', 'message' => 'Formato de correo electrónico incorrecto'],  
            ['email', 'string', 'max' => 100, 'message' => 'Máximo 100 caracteres'],  

            ['password', 'required', 'message' => 'Campo requerido'],  
            ['password', 'string', 'length' => [6, 255], 'message' => 'La contraseña debe tener entre 6 y 255 caracteres'],  
        ];  
    }  
}