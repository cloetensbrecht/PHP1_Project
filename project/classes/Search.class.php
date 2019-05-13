<?php

require_once 'bootstrap.php';
class Search
{
    //private $searchInput;

    public function checkSearchInput() //static
    {
        // FEATURE 6 - SEARCH
        // $countRows = 0;
        if (!empty($_GET['searchInput'])) {
            // gets input from search
            $searchInput = $_GET['searchInput'];
            // htmlspecialchars() tegen XSS attack > changes characters to equivalents like < to &gt;
            $searchInput = htmlspecialchars($searchInput);
            // real_escape_string() tegen SQL injection
            //$searchInput = real_escape_string($searchInput);

            return $searchInput;
        } else {
            return $searchInput = '';
        }
    }

    // CHECK length of searchInput
    public function checkSearchInputLength()
    {
        $searchInput = $this->checkSearchInput();

        // minimum length of searchInput
        $min_length = 2;

        if (strlen($searchInput) <= $min_length) {
            //if (!strlen($searchInput) >= $min_length) {
            $lengthCheck = 2;
        } elseif (!empty($_GET['searchInput'])) {
            $lengthCheck = 3;
        } else {
            $lengthCheck = 1;
        }

        return $lengthCheck;
    }

    public function searchResultsFormDb()
    {
        $conn = Db::getInstance(); // db connection
        $searchInput = $this->checkSearchInput();
        // items = table name in db
        $statement = $conn->prepare("SELECT * FROM posts, users WHERE users.id = posts.user_id AND description LIKE '%$searchInput%' ORDER BY users.id DESC LIMIT 10");
        // title, username zoeken?
        $statement->execute();
        $searchResults = $statement->fetchAll();
        //print_r($resultInput); // print hele array van resultaat
        return $searchResults;
    }

    public function countSearchResultsFormDb()
    {
        $count = count($this->searchResultsFormDb());
        // = ALTIJD MAX 10 = LIMIT

        /*
        $conn = Db::getInstance(); // db connection
        $searchInput = $this->checkSearchInput();
        $counter = $conn->prepare("SELECT COUNT(*) FROM posts, users WHERE users.id = posts.user_id AND description LIKE '%$searchInput%'");
        $counter->execute();
        $countRows = $counter->fetchColumn();
        $countRows = $counter->fetchColumn(); // OR  $countRows = $statement->rowCount();
        */
        return $count;
    }

    public function showMessageSearchResults()
    {
        $searchInput = $this->checkSearchInput();

        // minimum length of searchInput
        $min_length = 2;

        if (strlen($searchInput) <= $min_length) {
            $message = 'First enter what you want to look for. The minimum length is '.$min_length;
        } elseif ($this->countSearchResultsFormDb() >= 1) {
            $message = 'We found '.$this->countSearchResultsFormDb().' results for '.$searchInput;
        } elseif ($this->countSearchResultsFormDb() == 0) {
            $message = 'We found no results for '.$searchInput;
        } else {
            $message = 'Oops, first enter what you want to look for. ';
        }

        return $message;
    }
}
