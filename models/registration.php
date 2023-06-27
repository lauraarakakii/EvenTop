<?php

class Registration{
    public $idregistrations;
    public $status;
    public $event_idevents;
    public $users_idusers;

}

interface RegistrationDAOInterface {

    public function isRegistered($event_idevents, $users_idusers);

    public function registerUser($event_idevents, $users_idusers);

    public function getEventRegistrations($event_idevents);

}


?>