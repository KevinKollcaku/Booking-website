<?php

require_once 'core/DbModel.php';

class Hotels extends DbModel{

    public string $Name = '';
    public string $Description = '';
    public ?int $Price = null;
    public ?int $Number_of_rooms = null;
    public ?int $User_ID =null;
    public ?int $Location_ID = null;

    private const TABLE_NAME = 'Hotels';
	/**
	 * @return string - table name in the database for the model
	 */
	public function tableName(): string {
        return self::TABLE_NAME;
	}
	
	/**
	 * @return array - simple array of string values that represent the database attributes of each model
	 */
	public function attributes(): array {
        return ['Name','Description','Price','Number_of_rooms','User_ID','Location_ID'];
	}   
	
	/**
	 * @return string - primary key in the database for each model
	 *                Usually is id but consider a Book model with ISBN as primary key
	 */
	public function primaryKey(): string {
        return 'Hotel_ID';
	}
	
	/**
	 * @return array - An associative array with rules
	 *               If you want your password to be not only a required field but also a valid password you return an array of:
	 *               [RULE_REQUIRED, [RULE_PREG_MATCH, 'regex_pattern', 'Error message in case the matching fails]
	 *               RULE_REQUIRED and RULE_EMAIL can be passed directly
	 *               RULE_MIN and RULE_MAX need another value, so you have to pass an array with two values, one for the rule and one for the boundary
	 *               RULE_PREG_MATCH needs the pattern and the error message you want to display if the match fails, therefore you need an array with 3 items
	 */
	public function rules(): array {
        $nameRegex = "/[a-zA-Z]{1,100}/";
        $descriptionRegex = "/[a-zA-Z]{1,3000}/";

        return [
            'Name ' => [[self::RULE_REQUIRED],[self::RULE_PREG_MATCH, $nameRegex, "Name should contain only letters and should not be longer than 100 caracters"]],
            'Description' => [[self::RULE_REQUIRED],[self::RULE_PREG_MATCH, $descriptionRegex, "Description should contain only letters and should not be longer than 3000 caracters"]],
            'Price' => [self::RULE_REQUIRED,[self::RULE_MIN, -1 ], [self::RULE_MAX, 2147483647 ]],
            'Number_of_rooms' => [self::RULE_REQUIRED, [self::RULE_MIN, -1 ], [self::RULE_MAX, 10000 ]],
        ];
	}

    public function save() {
        
        //$User_ID= Application::$APP->getUser()->find_id(['email' => Application::$user->email]);
        
        // there is no support for locations
        //$Location_ID =1;
        
        return parent::save();
    }

    public static function findOne(array $where, $tableName = self::TABLE_NAME): Hotels{      
        return parent::findOne($where, $tableName);
    }

    /**
	 * @return array - an array of associative arrays with all the infroamtions about hotels in it
	 */
    public static function find_all(){
        return parent::findAll(self::TABLE_NAME);
    }

    public function getHotelName():string
    {
        return $this->Name;
    }

}

