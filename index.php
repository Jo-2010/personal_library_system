<?php
    //Calling functions to start a session and set the time zone to America/São Paulo.
    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    //Adding, In a necessary and unique way, the "BookController.php" file, which contains the algorithm for the "BookController" class.
    require_once "controller/BookController.php";

    //Declaring variables: Action the user wishes to perform, received upon submitting a form to "index.php" itself via the "GET" method, and an object of the class "BookController".
    $action = $_GET['action'] ?? "";
    $controller = new BookController();

    //A "switch-case" code block to define what the algorithm will do for each type of desired action: save, remove, search or edit.
    switch($action) {
        case "save":
            //Declaring variables: Book title, author, year, period, and status sent via the "POST" method using the save form.
            $title = $_POST['title'];
            $author = $_POST['author'];
            $year = $_POST['year'];
            $period = $_POST['period'];
            $status = $_POST['status'];

            //Calling the save method from the object of the class "BookController".
            $controller->save($title, $author, $year, $period, $status);
        case "remove":

        break;

        case "search":

        break;

        case "edit":

        break;
    }

    //A "try-catch" code block to attempt to retrieve all books from the database(books.csv) and, should an exception be thrown, return the correct error message.
    try {
        //Declaring variable: An array of books from the method "getAll" of the object.
        $books = $controller->getAll();
    } catch(Exception $e) {
        //Declaring variable: An a empty array.
        $books = [];
        
        //A "switch-case" code block to define what message of exception will be release based on the error occurred: OPEN_FILE, READ_FILE or CLOSE_FILE.
        switch($e->getMessage()) {
            case "OPEN_FILE":
                //Assigning two additional associative indices—"text" and "type"—to the "messageTableBooks" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                $_SESSION['messageTableBooks'] = [
                    'text' => "Unable to access the book database. Please try again later.",
                    'type' => "error"
                ];
            break;
                        
            case "READ_FILE":
                //Assigning two additional associative indices—"text" and "type"—to the "messageTableBooks" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                $_SESSION['messageTableBooks'] = [
                    'text' => "An error occurred while loading the book list. Please try again later.",
                    'type' => "error"
                ];
            break;

            case "CLOSE_FILE":
                //Assigning two additional associative indices—"text" and "type"—to the "messageTableBooks" associative index of the "$_SESSION" superglobal variable, in order to store the text to be displayed and the CSS class to be used for the message.
                $_SESSION['messageTableBooks'] = [
                    'text' => "Books were loaded successfully, but the system encountered a minor issue while closing the file. Please try again later.",
                    'type' => "warning"
                ];
            break;
        }
    }

    //Adding, in a non-necessary manner, the "home.php" file, where the table of books based on the array of books "$books" will be displayed—or error messages or an "empty library" notice shown—along with the form for saving a book.
    include "view/home.php";