<?php

    class Event {

        public $idevents;
        public $title;
        public $description;
        public $date;
        public $time;
        public $location;
        public $price;
        public $images;
        public $users_idusers;
        public $categories_idcategories;
        public $category_name;
        public $rating;


        public function imageGenerateName(){
            return bin2hex(random_bytes(60)) . ".jpg";
        }

    }

    interface EventDAOInterface {

        public function buildEvent($data);
        public function findAll();
        public function getLatestEvents();
        public function getEventsByCategory($categories_idcategories);
        public function getEventsByUserId($idevents);
        public function findById($idevents);
        public function findByTitle($title);
        public function create(Event $event);
        public function update(Event $event);
        public function destroy($idevents);

        public function getRegistrations($idevents);


    }