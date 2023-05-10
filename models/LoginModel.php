<?php

require_once 'core/BaseModel.php';
require_once 'models/User.php';

class LoginModel extends BaseModel
{
    public string $email = '';
    public string $password = '';
    public function rules(): array
    {
        $passwordRegex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,32}$/";
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_PREG_MATCH, $passwordRegex, "Password very week"]]
        ];
    }

    public function login(): bool
    {   
        try {
            $user = User::findOne(['email'=>$this->email]);
        } catch (\Throwable $th) {
            $user = null;
            //TODO delte this as well
            //exit("Fatale error when searching");
        }

        //TODO delete this
        if(isset($user)){
            //$temp=$user->firstName;
            //$truthe=!is_null($user);
            //exit("firstnaem = {$temp} and is it null = {$truthe}");
        }

        
        if(!$user) {
            $this->addError('email','User does not exist');
            return false;
        }

        //TODO delte this fields
        // {
        // $string1 = $this->password;
        // $string2=  $user->password;
        // $seeing_better = password_hash($string1,PASSWORD_DEFAULT);

        // echo "<p> why is this happening $string1 ||  $seeing_better <=> $string2 </p>";

        // // if(password_verify($this->password, $user->password)){
        // //     echo "<br><p> this is very good </p>";
        // // }

        // //exit();
        // }

        if(!password_verify($this->password, $user->password)){
            //TODO delte this info leve only Passowrd is incorrect
            //$checker = $user->firstName;
            $this->addError('password', "Password is incorrect");
            return false;
        }
        Application::$APP->setUserData($user);
        return true;
    }

    public function labels(): array
    {
        return [
            'email' => 'Your email',
            'password' => 'Password'
        ];
    }
}