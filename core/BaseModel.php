<?php

abstract class BaseModel
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_UNIQUE = 'unique';
    public const RULE_PREG_MATCH = 'preg_match';
    public const RULE_TEST = 'test';

    public array $errors = [];

    /**
     * @param $data - will get the data from the request and load it in the current model
     * @return void
     */
    public function loadData($data): void
    {   
        //TODO delte
        //$truthe = sizeof($data);
        //echo "{$truthe}";

        foreach ($data as $k=>$v) {
            if(property_exists($this, $k)) {
                
                if(is_int($this->{$k})){
                    $this->{$k} =intval($v);    
                }
                $this->{$k} = $v;
                //echo "<br><p> We are setting this variable here: {$k}</p> ";
            }
            //echo "<br><p> we are not setting this variable</p>";
        }
    }

    /**
     * @return array - An associative array with rules
     * If you want your password to be not only a required field but also a valid password you return an array of:
     * [RULE_REQUIRED, [RULE_PREG_MATCH, 'regex_pattern', 'Error message in case the matching fails]
     * RULE_REQUIRED and RULE_EMAIL can be passed directly
     * RULE_MIN and RULE_MAX need another value, so you have to pass an array with two values, one for the rule and one for the boundary
     * RULE_PREG_MATCH needs the pattern and the error message you want to display if the match fails, therefore you need an array with 3 items
     */
    abstract public function rules(): array;

    public function labels():array {
        return [];
    }

    public function getLabel($attribute) {

        //it will return the requred label, if it has a different name from the actuall one that is beeing used
        return $this->labels()[$attribute] ?? $attribute;
    }

    /**
     * @return bool - true if the model being checked passes all the self-defined rules otherwise false
     */
    public function validate(): bool
    {
        /*
             $passwordRegex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,32}$/";
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_PREG_MATCH, $passwordRegex, "Password very week"]],
        ];
        */

        /*
        return [
            'Numbe_of_days' => [[self::RULE_MIN, -1 ], [self::RULE_MAX, 100 ]],
            'Number_of_People' => [[self::RULE_MIN, -1 ], [self::RULE_MAX, 100 ]],
        ];
        */
        foreach ($this->rules() as $attribute => $rules) {

            //we are actually getting the actuall value that the model currently has stored
            //
            //echo "<p>{$attribute} </p><br>";
            $attribute=trim($attribute);
            //echo " <p>the string {$this->{$attribute}}</p><br>";

            $value = $this->{$attribute};

            

            foreach ($rules as $rule){

                $ruleName = $rule;


                //TODO check
                // if (!is_string($ruleName)){
                    
                //     //in cases when we have specified a rule aname like RULE_MIN
                //     //which actually takes as parameter an integer and not a string
                //     echo "<p>the not string $rule[0]</p>";
                //     $ruleName = $rule[0];
                // }

            //exit();

                if($ruleName === self::RULE_REQUIRED && !$value && $value != 0) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                //we are checking for a valid email by using the fucntion that php provides
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                //minimun character required
                //[self::RULE_MIN, 12 ]
                if($ruleName === self::RULE_MIN && strlen($value) <= $rule[1]) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, ['min' => $rule[1]]);
                }

                //maximal character length
                if($ruleName === self::RULE_MAX && strlen($value) >= $rule[1]) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, ['max' => $rule[1]]);
                }

                //checking in the database for a unique attribute
                if($ruleName === self::RULE_UNIQUE) {
                    
                    //[self::RULE_UNIQUE, self::class]

                    $className = $rule[1];
                    
                    //email
                    //from 'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, self::class]],
                    //used to search in the database
                    $uniqueAttribute = $rule[2] ?? $attribute;

                    //returns the table name that the class stores, thus making it versitile when compared with
                    //the database
                    $tableName = $className::tableName();

                    
                    $stmt = Application::$APP->getDb()->prepare("select * from $tableName where $uniqueAttribute = :attr");
                    $stmt->bindValue(":attr", $value);
                    $stmt->execute();

                    $record = $stmt->fetchObject();
                    
                    //we are actually adding the error if there is an existing record
                    if($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field'=>$this->getLabel($attribute)]);
                    }
                }

                //working with this kind of data strucutre
                //[self::RULE_PREG_MATCH, $passwordRegex, "Password very week"]

                if($ruleName === self::RULE_PREG_MATCH) {
                    $regex = $rule[1];
                    $errorMsg = $rule[2];
                    
                    if(!preg_match($regex, $value)) {
                        $this->addError($attribute, $errorMsg);
                    }

                }
            }
        }
        return empty($this->errors);
    }


    //addErrorForRule($attribute, self::RULE_MAX, ['max' => $rule[1]])
    private function addErrorForRule($attribute, $rule, $params = []): void
    {
        //checking if we have defined a message for our rule or not
        $msg = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $k => $v) {
            
            //in cases where we have min or max unique attributes will actually be shown
            //the actuall attribute
            $msg = str_replace("{{$k}}", $v, $msg);
        }
        $this->errors[$attribute][] = $msg;
    }


    //simpler version of the previouse error Adder
    public function addError($attribute, $msg): void
    {
        $this->errors[$attribute][] = $msg;
    }


    //defining the text that will be shown to the user
    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "This field must be a valid email address",
            self::RULE_MIN => "Min length of this field must be {min}",
            self::RULE_MAX => "Max length of this field must be {max}",
            self::RULE_UNIQUE => "Record with this {field} already exists",
            self::RULE_TEST => "Sorry this is still under testing",
        ];
    }

    //just checks for an error
    public function hasError($attribute) {
        return $this->errors[$attribute] ?? false;
    }

    //get the frist error
    public function getFirstError($attribute) {
        return $this->errors[$attribute][0] ?? '';
    }

}