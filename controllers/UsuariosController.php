<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Usuarios;
use app\models\FormUsuarios;

class UsuariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new FormUsuarios();
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $usuario = new Usuarios();
                $usuario->username = $model->username;
                $usuario->email = $model->email;
                $usuario->password = $model->password;
                $usuario->setPassword($model->password);
                $usuario->generateAuthKey();

                if ($usuario->save()) {
                    $msg = "Enhorabuena, usuario registrado correctamente";
                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                } else {
                    $msg = "Ha ocurrido un error al insertar el registro";
                }
            } else {
                $model->getErrors();
            }
        }

        return $this->render("create", ['model' => $model, 'msg' => $msg]);
    }

    public function actionIndex()
    {
        $usuarios = Usuarios::find()->all();
        return $this->render('index', ['usuarios' => $usuarios]);
    }

    public function actionView($id)
    {
        $usuario = Usuarios::findOne($id);
        if (!$usuario) {
            throw new \yii\web\NotFoundHttpException("El usuario no existe");
        }
        return $this->render('view', ['usuario' => $usuario]);
    }

    public function actionDelete($id)
    {
        $usuario = Usuarios::findOne($id);
        if ($usuario) {
            $usuario->delete();
            Yii::$app->session->setFlash('success', 'Usuario eliminado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'El usuario no existe.');
        }

        return $this->redirect(['index']);
    }

    public function actionEdit($id)
    {
        $usuario = Usuarios::findOne($id);
        if (!$usuario) {
            throw new \yii\web\NotFoundHttpException("El usuario no existe");
        }

        $model = new FormUsuarios();
        $model->username = $usuario->username;
        $model->email = $usuario->email;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $usuario->username = $model->username;
            $usuario->email = $model->email;

            if ($model->password) {
                $usuario->setPassword($model->password);
            }

            if ($usuario->save()) {
                Yii::$app->session->setFlash('success', 'Usuario actualizado correctamente.');
                return $this->redirect(['view', 'id' => $usuario->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Error al actualizar el usuario.');
            }
        }

        return $this->render('edit', ['model' => $model, 'usuario' => $usuario]);
    }
}
