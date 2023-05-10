<?php

require_once 'core/BaseController.php';
require_once 'models/Hotels.php';
require_once 'models/Bookings.php';

class HotelsController extends BaseController
{
    public function list() {
        
        if(!Application::$APP->isAuthenticated()) {
            throw new UnauthorizedException();
        }

        if(Request::isGet()){
            $Hotels = Hotels::find_all();
            return Application::$APP->getRouter()->renderView('hotels', ['hotels' => $Hotels]);
        }

        Response::redirect('/');
    }


    public function register(){

        if(!Application::$APP->isAuthenticated()) {
            throw new UnauthorizedException();
        }
        $hotel = new Hotels();

        if(Request::isPost()) {       

            $hotel->loadData(Request::requestBody());
            
            //unfortunately we couldnt implement the location for every hotel
            $hotel->Location_ID=1;

            $hotel->User_ID = (int)User::find_id(['email'=>Application::$APP->getUser()->email],'users');

            if($hotel->validate() && $hotel->save()) {
                Response::redirect('/');
            }
            return Application::$APP->getRouter()->renderView('register_hotel', ['model'=>$hotel]);
        }

        return Application::$APP->getRouter()->renderView('register_hotel', ['model'=>$hotel]);
    }

    public function book(){
        
        if(!Application::$APP->isAuthenticated()) {
            throw new UnauthorizedException();
        }

        $booking = new Bookings();

        if(Request::isPost()) { 

            $booking->loadData(Request::requestBody());

            $booking->User_ID = (int)User::find_id(['email'=>Application::$APP->getUser()->email],'users');

            // foreach ($booking as $key => $value) {
            //     echo $key . "  <=>  " . $value . "<br>";
            // }
            // exit();

            if($booking->validate() && $booking->save()) {
                Response::redirect('/');
            }


            return Application::$APP->getRouter()->renderView('bookings', ['model'=>$booking]);
        }else{

            //TODO list all bookings
            $Bookings = Bookings::find_all();

            return Application::$APP->getRouter()->renderView('bookings', ['Bookings'=>$Bookings]);
        }
    }
}