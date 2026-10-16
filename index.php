<?php
    //Calling the functions "session_start" and "date_default_timezone_set" to start a session and set the time zone to America/São Paulo.
    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    //Adding, in a necessary and unique way, the "BookController.php" file, which contains the algorithm for the "BookController" class.
    require_once "controller/BookController.php";

    //Declaring variables: the action the user wishes to perform, received when submitting a form to "index.php" via the "GET" method in the URL. If no action is present in the URL, the variable remains empty. Also, an object of the "BookController" class.
    $action = $_GET['action'] ?? "";
    $controller = new BookController();

    //A "switch-case" code block to define what the algorithm will do for each type of desired action: save, confirmSave, remove, search or edit.
    switch($action) {
        case "save":
            //Declaring variables: book title, author, year, period, and status sent via the "POST" method using the save form.
            $title = $_POST['title'];
            $author = $_POST['author'];
            $year = $_POST['year'];
            $period = $_POST['period'];
            $status = $_POST['status'];

            //Calling the save method from the object of the class "BookController" to save a book.
            $controller->save($title, $author, $year, $period, $status);

        case "confirmSave":
            //An "if-else" code block which checks whether the associative key 'addAnyway' in the '$_SESSION' superglobal has been initialized with a value and is not null. If it has been initialized, we will save the book using the data stored in the 'oldValues' associative key within the '$_SESSION' superglobal. If it has not been initialized, we reset the associative keys in the '$_SESSION' superglobal and redirect the user to the book-saving form.
            if(isset($_POST['addAnyway'])) {
                //Calling the save method from the object of the class "BookController" to save a book.
                $controller->save($_SESSION['oldValues']['title'], $_SESSION['oldValues']['author'], $_SESSION['oldValues']['year'], $_SESSION['oldValues']['period'], $_SESSION['oldValues']['status']);
            } else {
                //Resetting the associative keys 'possibleDuplicate' and 'oldValues' of the superglobal "$_SESSION" from scratch.
                unset($_SESSION['possibleDuplicate']);
                unset($_SESSION['oldValues']);
                //Calling the functions "header" and "exit" to redirect the user back to the home page(index.php, in the save book form) and immediately terminates script execution to ensure that no further processing or unintended data writing occurs after validation, error handling, or successful operation.
                header("Location: index.php#titleFormSaveBook");
                exit();
            }

        case "remove":

        break;

        case "search":

        break;

        case "edit":

        break;
    }

    //A "try-catch" code block to attempt to retrieve all books from the database(books.csv) and, should an exception be thrown, return the correct error message.
    try {
        //Declaring variable: an array of books from the method "getAll" of the object.
        $books = $controller->getAll();
    } catch(Exception $e) {
        //Declaring variable: an empty array.
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