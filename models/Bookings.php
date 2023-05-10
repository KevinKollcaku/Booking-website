<?php

require_once 'core/DbModel.php';

class Bookings extends DbModel
{
    public int $Hotel_ID = 1;
    public int $User_ID = 1;
    public ?int $Number_of_days = 0;
    public ?int $Number_of_People = 0;
    public ?string $Start_date = '';
    private const TABLE_NAME = 'bookings';


    public function save() {
        //TODO we can implement the assembling here
        return parent::save();
    }

    public function rules(): array
    {
        // return [
        //     'Numbe_of_days' => [[self::RULE_MIN, -1 ], [self::RULE_MAX, 100 ]],
        //     'Number_of_People' =>[ [self::RULE_MIN, -1 ], [self::RULE_MAX, 100 ]],
        // ];

        return [];
    }

    /**
     * @return string[]
     * keys should correspond to the attributes and values will be displayed in the HTML document
     */
    public function labels(): array
    {
        return [
            'Number_of_days' => 'Number of days',
            'Number_of_People' => 'Number of People',
            'Start_date' => 'Start date',
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
        return ['Hotel_ID', 'User_ID', 'Number_of_days', 'Number_of_People','Start_date'];
    }

    public static function findOne(array $where, $tableName = self::TABLE_NAME): User
    {   

        return parent::findOne($where, $tableName);
    }


    public function primaryKey(): string
    {
        return 'ID';
    }

    public static function find_all(){
        $all_bookings = parent::findAll(self::TABLE_NAME);

        $correct_bookings = [];
        $the_user_id = (int)User::find_id(['email'=>Application::$APP->getUser()->email],'users');

        foreach ($all_bookings as $key => $value) {
            if($value['User_ID']==$the_user_id){
                $correct_bookings[]=$value;
            }
        }
        return $correct_bookings;
    }

}