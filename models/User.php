<?php

require_once 'core/DbModel.php';

class User extends DbModel
{
    public string $firstName = '';
    public string $lastName = '';
    public string $password = '';
    public string $email = '';
    public string $username = '';
    public ?int $access_level = null;
    public string $Telephone_Number = '';
    public string $Date_Created = '';

    private const TABLE_NAME = 'users';

    public function save() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        //this are the rules based in the base class plus some that we can add for the regex part
        //
        $passwordRegex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,32}$/";
        $phonenumberRegex = "/[0-9]{3}-[0-9]{3}-[0-9]{4}/";
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_PREG_MATCH, $passwordRegex, "Password very week"]],
            'username' => [self::RULE_REQUIRED],
            'access_level' => [self::RULE_REQUIRED, [self::RULE_MIN, -1 ], [self::RULE_MAX, 2 ]],
            'Telephone_Number' => [self::RULE_REQUIRED, [self::RULE_PREG_MATCH, $phonenumberRegex, "Telephone Number should be xxx-xxx-xxxx"]],
            'Date_Created' => [self::RULE_REQUIRED],
        ];
    }

    /**
     * @return string[]
     * keys should correspond to the attributes and values will be displayed in the HTML document
     */
    public function labels(): array
    {
        return [
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'username' => 'Username',
            'access_level' => 'Choose your Role',
            'Telephone_Number' => 'Telephone Nubmer',
            'Date_Created' => 'Date of birthday',
        ];
    }

    public function tableName(): string
    {
        return self::TABLE_NAME;
    }

    /**
     * @return string[]
     * return all the DB properties of this class
     * you may create other properties not part of the DB model
     */
    public function attributes(): array
    {
        return ['firstName', 'lastName', 'email', 'password','username','access_level','Telephone_Number','Date_Created'];
    }

    public static function findOne(array $where, $tableName = self::TABLE_NAME): User
    {   

        return parent::findOne($where, $tableName);
    }


    public function primaryKey(): string
    {
        return 'user_id';
    }

    public function getDisplayName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public static function find_id(array $where, $tableName )
    {
        
        $the_subject=parent::find_id($where, $tableName);

        // echo $the_subject['user_ID'];
        // exit();
        
        return (int)$the_subject['user_ID'];
    }
}