<?php
    //Adding, in a necessary and unique way, the "BookModel.php" file, which contains the algorithm for the "BookModel" class.
    require_once __DIR__ . "/../model/BookModel.php";

    //Creation and modeling of the "BookController" class—the intermediary between what the user sees and the data management layer—which decides whether or not to execute operations on the "model" based on data received from the "view".
    class BookController {
        //Creating the "getAll" method, which is responsible for instantiating the "BookModel" class, calling the BookModel's getAll method, and returning an array of books saved in the database(books.csv) or throwing an exception based on the one thrown by "BookModel".
        public function getAll() {
            //Declaring variable: an object of the class "BookModel".
            $model = new BookModel();

            //A "try-catch" code block where we attempt to use the "getAll" method of the "BookModel" object stored in "$model" to retrieve the books from the database(books.csv) and store them in the "$books" variable. If an exception is thrown by this "model" method, we re-throw that same exception.
            try {
                //Declaring a variable: an array of books from the "getAll" method of the "BookModel" class object.
                $books = $model->getAll();
            } catch(Exception $e) {
                //Throwing an exception using the message from an exception caught during the call to the "getAll" method of the object instantiated from the "BookModel" class. 
                throw new Exception($e->getMessage());
            }

            //Returning the array of books, contained in "$books".
            return $books;
        }

        //Creating the "save" method, which it is responsible for validating the book's attributes and checking whether the book already exists in the database(books.csv). If validation succeeds, the book is saved using the "save" method of the "BookModel" class instance, and a success message is recorded in the session. If any validation or functional errors occur during the process, the errors are stored in the session and the corresponding exceptions are raised.
        public function save($title, $author, $year, $period, $status) {
            //Declaring variables: storing the boolean returns from the attribute text validation functions to determine whether the values ​​are valid.
            $validatedTitle = $this->validateTitle($title);
            $validatedAuthor = $this->validateAuthor($author);
            $validatedYear = $this->validateYear($year, $period);
            $validatedPeriod = $this->validatePeriod($period);
            $validatedStatus = $this->validateStatus($status);

            //An "if-else" code block: if any attribute fails validation, the values ​​used in the submission are stored in the session and the user is redirected to "index.php"; otherwise, data verification proceeds.
            if(!($validatedTitle && $validatedAuthor && $validatedYear && $validatedPeriod && $validatedStatus)) {
                //Assigning five associative keys to the "oldValues" associative key of the "$_SESSION" superglobal, representing the five values ​​received from the form that are to be returned to it via a session variable.
                $_SESSION['oldValues'] = [
                    'title' => $title,
                    'author' => $author,
                    'year' => $year,
                    'period' => $period,
                    'status' => $status
                ];

                //Calling the functions "header" and "exit" to redirect the user back to the home page(index.php) and immediately terminates script execution to ensure that no further processing or unintended data writing occurs after validation, error handling, or successful operation.
                header("Location: index.php");
                exit();
            } else {
                //Declaring variable: object of the class "BookModel".
                $model = new BookModel();

                //A "try-catch" code block attempts to check if the book is a duplicate and, if not, save it. If an exception is thrown during the book verification and saving processes, the appropriate error message is stored in the "$_SESSION" superglobal variable, and the algorithm redirects to "index.php".
                try {
                    //An "if-else" code block that checks whether the received attributes—title and author—correspond to a book that is already registered. If so, it saves error messages and the form fields' previous values ​​and redirects to "index.php"; otherwise, it saves the book, stores a success message in the session, and returns to "index.php".
                    if($model->exists(trim($title), trim($author))) {
                        //Assigning two additional associative indices—"text" and "type"—to the "messageFormSave" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                        $_SESSION["messageFormSave"] = [
                            "text" => "This book is already registered in your library.",
                            "type" => "warning"
                        ];
                        //Assigning five associative keys to the "oldValues" associative key of the "$_SESSION" superglobal, representing the five values ​​received from the form that are to be returned to it via a session variable.
                        $_SESSION["oldValues"] = [
                            "title" => $title,
                            "author" => $author,
                            "year" => $year,
                            "period" => $period,
                            "status" => $status
                        ];

                        //Calling the functions "header" and "exit" to redirect the user back to the home page(index.php) and immediately terminates script execution to ensure that no further processing or unintended data writing occurs after validation, error handling, or successful operation.
                        header("Location: index.php");
                        exit();
                    } else {
                        //Calling the method "save" of the object to save a book.
                        $model->save(trim($title), trim($author), trim($year), trim($period), trim($status));

                        //Assigning two additional associative indices—"text" and "type"—to the "messageFormSave" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                        $_SESSION["messageFormSave"] = [
                            "text" => "The book was saved successfully.",
                            "type" => "success"
                        ];

                        //Calling the functions "header" and "exit" to redirect the user back to the home page(index.php) and immediately terminates script execution to ensure that no further processing or unintended data writing occurs after validation, error handling, or successful operation.
                        header("Location: index.php");
                        exit();
                    }
                } catch(Exception $e) {
                    //A "switch-case" code block to define what message of exception will be release based on the error occurred: OPEN_FILE, WRITE_FILE, CLOSE_FILE, READ_FILE_EXISTS and CLOSE_FILE_EXISTS.
                    switch($e->getMessage()) {
                        case "OPEN_FILE":
                            //Assigning two additional associative indices—"text" and "type"—to the "messageFormSave" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                            $_SESSION["messageFormSave"] = [
                                "text" => "An internal error occurred while accessing the library data. Please try again later.",
                                "type" => "error"
                            ];
                        break;
                        
                        case "WRITE_FILE":
                            //Assigning two additional associative indices—"text" and "type"—to the "messageFormSave" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                            $_SESSION["messageFormSave"] = [
                                "text" => "The book could not be saved due to an internal error. Please try again later.",
                                "type" => "error"
                            ];
                        break;

                        case "CLOSE_FILE":
                            //Assigning two additional associative indices—"text" and "type"—to the "messageFormSave" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                            $_SESSION["messageFormSave"] = [
                                "text" => "The book was saved successfully, but a minor system warning occurred while finishing the operation.",
                                "type" => "warning"
                            ];
                        break;

                        case "READ_FILE_EXISTS":
                            //Assigning two additional associative indices—"text" and "type"—to the "messageFormSave" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                            $_SESSION["messageFormSave"] = [
                                "text" => "We couldn't verify whether this book is already registered. Please try again later.",
                                "type" => "error"
                            ];
                        break;

                        case "CLOSE_FILE_EXISTS":
                            //Assigning two additional associative indices—"text" and "type"—to the "messageFormSave" associative index of the "$_SESSION" superglobal, in order to store the text to be displayed and the CSS class to be used for the message.
                            $_SESSION["messageFormSave"] = [
                                "text" => "The book was not saved because the system encountered an issue while checking the library records.",
                                "type" => "warning"
                            ];
                        break;
                    }

                    //Calling the functions "header" and "exit" to redirect the user back to the home page(index.php) and immediately terminates script execution to ensure that no further processing or unintended data writing occurs after validation, error handling, or successful operation.
                    header("Location: index.php");
                    exit();
                }
            }
        }
        
        //
        public function remove($indexBook) {
            $model = new BookModel();

            $model->remove($indexBook);
        }

        public function search($indexBook) {
            $model = new BookModel();
            $bookToSearch = $model->search($indexBook);

            return $bookToSearch;
        }

        public function edit($indexBook, $title, $author, $year, $status) {
            $model = new BookModel();

            $model->edit($indexBook, $title, $author, $year, $status);
        }

        //Creating the "validateTitle" method, which receives the book title submitted by the user and performs several checks to determine if the title is valid; it returns "false" if any aspect of the title is invalid—while also storing the error message in the "$_SESSION" superglobal variable—and returns "true" if it passes all checks.
        private function validateTitle($titleBook) {
            //An "if-else if-else" code block that performs multiple checks to validate the book title and stores the error type in the "$_SESSION" superglobal variable.
            if(mb_strlen($titleBook) === 0) {
                //Assigning the error message explaining the cause of the error to the "title" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['title'] = "Title is required.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(mb_strlen(trim($titleBook)) === 0) {
                //Assigning the error message explaining the cause of the error to the "title" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['title'] = "Title cannot contain only spaces.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(mb_strlen(trim($titleBook)) > 250) {
                //Assigning the error message explaining the cause of the error to the "title" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['title'] = "Title cannot exceed 250 characters.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(!preg_match("/^[\p{L}\p{N} .,;:!?&\'\(\)\-]+$/u", trim($titleBook))) {
                //Assigning the error message explaining the cause of the error to the "title" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['title'] = "Title contains invalid characters.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else {
                //Due to a validation, the method returns "true".
                return true;
            }
        }

        //Creating the "validateAuthor" method, which receives the book's author submitted by the user and performs several checks to determine if the author is valid; it returns "false" if any aspect of the author is invalid—while also storing the error message in the "$_SESSION" superglobal variable—and returns "true" if it passes all checks.
        private function validateAuthor($authorBook) {
            //An "if-else if-else" code block that performs multiple checks to validate the book's author and stores the error type in the "$_SESSION" superglobal variable.
            if(mb_strlen($authorBook) === 0) {
                //Assigning the error message explaining the cause of the error to the "author" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['author'] = "Author is required.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(mb_strlen(trim($authorBook)) === 0) {
                //Assigning the error message explaining the cause of the error to the "author" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['author'] = "Author cannot contain only spaces.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(mb_strlen(trim($authorBook)) < 2) {
                //Assigning the error message explaining the cause of the error to the "author" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['author'] = "Author cannot contain fewer than 2 characters.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(mb_strlen(trim($authorBook)) > 100) {
                //Assigning the error message explaining the cause of the error to the "author" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['author'] = "Author cannot exceed 100 characters.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(!preg_match("/^[\p{L}\p{M} .'\-]+$/u", trim($authorBook))) {
                //Assigning the error message explaining the cause of the error to the "author" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['author'] = "Author contains invalid characters.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else {
                //Due to a validation, the method returns "true".
                return true;
            }
        }

        //Creating the "validateYear" method, which receives the book's year submitted by the user and performs several checks to determine if the year is valid; it returns "false" if any aspect of the year is invalid—while also storing the error message in the "$_SESSION" superglobal variable—and returns "true" if it passes all checks.
        private function validateYear($yearBook, $periodBook) {
            //An "if-else if-else" code block that performs multiple checks to validate the book's year and stores the error type in the "$_SESSION" superglobal variable.
            if(mb_strlen($yearBook) === 0) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Year is required.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(mb_strlen(trim($yearBook)) === 0) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Year cannot contain only spaces.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if((int) $yearBook <= 0) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Year must be a positive, non-null integer.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(preg_match("/[^0-9.,]/", trim($yearBook))) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Year must be numeric.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(preg_match("/^0[0-9]+/", trim($yearBook))) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Year cannot contain leading zeros.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if(preg_match("/[.,]/", trim($yearBook))) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Year must be an integer.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if($periodBook === "B.C." && (int) $yearBook > 3300) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Invalid year for the period B.C.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else if($periodBook === "A.C." && (int) $yearBook > (int) date('Y')) {
                //Assigning the error message explaining the cause of the error to the "year" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['year'] = "Invalid year for the period A.C.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else {
                //Due to a validation, the method returns "true".
                return true;
            }
        }

        //Creating the "validatePeriod" method, which receives the book's period submitted by the user and performs a check to determine if the period is valid; it returns "false" if any aspect of the period is invalid—while also storing the error message in the "$_SESSION" superglobal variable—and returns "true" if it passes in the check.
        private function validatePeriod($periodBook) {
            //An "if-else" code block that performs a check to validate the book's period and stores the error type in the "$_SESSION" superglobal variable.
            if(trim($periodBook) !== "B.C." && trim($periodBook) !== "A.C.") {
                //Assigning the error message explaining the cause of the error to the "period" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['period'] = "Select the historical period.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else {
                //Due to a validation, the method returns "true".
                return true;
            }
        }

        //Creating the "validateStatus" method, which receives the book's status submitted by the user and performs a check to determine if the status is valid; it returns "false" if any aspect of the status is invalid—while also storing the error message in the "$_SESSION" superglobal variable—and returns "true" if it passes in the check.
        private function validateStatus($statusBook) {
            //An "if-else" code block that performs a check to validate the book's status and stores the error type in the "$_SESSION" superglobal variable.
            if(trim($statusBook) !== "I want to read" && trim($statusBook) !== "Reading" && trim($statusBook) !== "Read") {
                //Assigning the error message explaining the cause of the error to the "status" associative key—nested within the "errors" associative key—in the "$_SESSION" superglobal variable.
                $_SESSION['errors']['status'] = "Select the book's status.";

                //Due to an invalidation, the method returns "false".
                return false;
            } else {
                //Due to a validation, the method returns "true".
                return true;
            }
        }
    }