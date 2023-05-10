<?php

require_once 'core/BaseModel.php';

abstract class DbModel extends BaseModel
{
    /**
     * @return string - table name in the database for the model
     */
    abstract public function tableName(): string;

    /**
     * @return array - simple array of string values that represent the database attributes of each model
     */

    abstract public function attributes(): array;

    /**
     * @return string - primary key in the database for each model
     * Usually is id but consider a Book model with ISBN as primary key
     */

    abstract public function primaryKey(): string;

    /**
     * @return true - whether saving the object was successful
     * Generic query to save DB models, you don't have to write a separate query for each model
     * Just make sure to define attributes correctly for each model
     */
    public function save() {

        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($x) => ":$x", $attributes);

        $stmt = self::prepare("insert into $tableName (" . implode(',', $attributes)
            . ") values (" . implode(",", $params) . ");");

    
        
        foreach ($attributes as $attribute) {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }

        $stmt->execute();
        return true;
    }

    public static function prepare($sql) {
        return Application::$APP->getDb()->prepare($sql);
    }

    /**
     * @param array $where - an associative array containing query params you want to search
     * @param $tableName - table name
     * @return DbModel Generic query to search for a single row
     * Generic query to search for a single row
     * If you want to search for User with first name Foo and last name Bar pass $where = ['firstName'=>'Foo', 'lastName' => 'Bar']
     */
    public static function findOne(array $where, $tableName): self
    {
        $attributes = array_keys($where);
        $str = implode("and ", array_map(fn($x) => "$x = :$x", $attributes));


        //TODO delete this echo
        //echo "<p> select * from $tableName where $str;</p>";
        $stmt = self::prepare("select * from $tableName  where $str;");
        foreach ($where as $k => $v) {
            $stmt->bindValue(":$k", $v);
            //echo "<p> printing from here {$v} </p>";
        }

        try {
            //echo "select * from $tableName  where $str;";
            //echo "<br><p> and here  <=> {$stmt} </p><br> ";
            $stmt->execute();
            //TODO delete this one {
            //$analyze = $stmt->fetchAll();
            //$see = $stmt->rowCount();
            //echo "<p>this is the number of tiems fetched $see </p> {$analyze[0]['password']} ";
            //exit();
            //$result = $stmt->fetchObject(static::class);
            //echo "<p>  {$result->firstName } {$result->lastName } {$result->password } {$result->email } {$result->username } {$result->access_level }{$result->Date_Created }</p>";
            //exit();
            //}
        } catch (\Throwable $th) {
        }
        return @$stmt->fetchObject(static::class);
    }


    /**
     * @return array -  array of all elements in the database
     */
    public static function findAll($tableName){
        
            $stmt = self::prepare("select * from $tableName;");

            $stmt->execute();

            //TODO delte this 
            //$result = $stmt->fetchAll();
            // foreach ($result as $hotel) {
            //     echo "<p>Hotel ID: {$hotel['Hotel_ID']}</p>";
            //     echo "<p>Hotel Name: {$hotel['Name']}</p>";
            //     echo "<p>Hotel Address: {$hotel['Description']}</p>";
            //     echo "<p>Hotel City: {$hotel['Number_of_rooms']}</p>";
            //     echo "<p>Hotel Country: {$hotel['Price']}</p>";
            //     echo "<p>Finished one of this</p>";
            // }
            // exit(); 


            return $stmt->fetchAll();
    }

     /**
     * @return array -  associative array containing the data of one element
     */
    public static function find_id(array $where, $tableName)
    {
        $attributes = array_keys($where);
        $str = implode("and ", array_map(fn($x) => "$x = :$x", $attributes));

        $stmt = self::prepare("select * from $tableName  where $str;");
        
        foreach ($where as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
    
        $stmt->execute();
            
        return $stmt->fetch();
    }
}