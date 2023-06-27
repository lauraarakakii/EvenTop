<?php

    class Review {
        public $idreviews;
        public $rating;
        public $review;
        public $event_users_idusers;
        public $users_idusers;
    }

    interface ReviewDAOInterface {
        public function buildReview($data);
        public function create(Review $review);
        public function getEventsReview($idreviews);
        public function hasAlreadyReviewed($idreviews, $users_idusers);
        public function getRating($idreviews);
    }
