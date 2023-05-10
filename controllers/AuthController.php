<?php
require_once 'models/LoginModel.php';
require_once 'core/BaseController.php';
require_once 'models/User.php';
require_once 'exceptions/MethodNotAllowedException.php';

class AuthController extends BaseController
{

    public function login() {
        $loginForm = new LoginModel();
        
        if(Request::isPost()) {
            $loginForm->loadData(Request::requestBody());
            //TODO delete this try and catch
            try {
                $loginForm->validate();
            } catch (\Throwable $th) {
                exit("faltale error with validation");
            }

            if($loginForm->validate() && $loginForm->login()) {
                Response::redirect('/');
                return;
            }
        }
        return Application::$APP->getRouter()->renderView('login', ['model' => $loginForm]);
    }

    public function register() {

        $user = new User();

        if(Request::isPost()) {       

            $user->loadData(Request::requestBody());

            //are we loading the data properly??
            // echo $user->firstName . "<br>";
            // echo $user->lastName . "<br>";
            // echo $user->password . "<br>";
            // echo $user->email . "<br>";
            // echo $user->username . "<br>";
            // echo $user->access_level . "<br>";
            // exit();

            

            //TODO delete this try and catch
            
            try {
                if($user->validate()){
                    //exit("{$user->validate()}");
                }
                //exit(" this is {$user->validate()}");
                
            } catch (\Throwable $th) {
                //exit("faltale error with validation");
            }

            if($user->validate() && $user->save()) {
                //echo "<p>We saved a user here</p>";
                //exit();
                Response::redirect('/');
                //exit;
            }else{
                //echo "<p>We didnt saved a user here because of : {$user->validate()}  and {$user->save()} </p>";
               // exit();
            }
            return Application::$APP->getRouter()->renderView('register', ['model'=>$user]);
        }

        return Application::$APP->getRouter()->renderView('register', ['model'=>$user]);
    }

    public function logout() {
        if(Request::isGet()) {
            Application::$APP->clearUserData();
            Response::redirect('/');
        } else throw new MethodNotAllowedException();
    }

}