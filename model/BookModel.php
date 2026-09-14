<?php
    //Creation and modeling of the "BookModel" class—A class that actually performs the actions modifying the database(books.csv) and throws exceptions if any part of the algorithm fails, while also offering the ability to check for duplicate books.
    class BookModel {
        //Creating the "getAll" method, it is responsible for iterating through the database file(books.csv), capturing valid book rows, storing them in the "$books" array, closing the file, and returning the "$books" array.
        public function getAll() {
            //Declaring variables: CSV file of the books(pointer to "read").
            $fileBooks = @fopen(__DIR__ . "/../data/books.csv", "r");

            //An "if" code block that checks if the file-opening function returned "false". If so, it logs the error to "error.log" and throws an exception.
            if($fileBooks === false) {
                //Calling the function "error_log" to write a message of log in "error.log" more easily.
                error_log("[" . date("Y-m-d H:i:s") . "] ERROR: Could not open 'books.csv' for reading." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");

                //Throwing an exception with the message "OPEN_FILE" for indicate the error type.
                throw new Exception("OPEN_FILE");
            }

            //Declaring variable: an empty array.
            $books = [];

            //A "while" code block, which will iterating through the CSV file to capture all existing books and store them in an array format.
            while(($lineBook = @fgetcsv($fileBooks, 1000, ",")) != false) {
                //An "if" code block that checks if the line catched in the CSV file contains 4 columns of datas, to ignore corrupted lines.
                if(count($lineBook) !== 4) {
                    //Instruction to skip to the next iteration of the "while" code block, if applicable.
                    continue;
                }

                //Assigning the "$lineBook" array—captured from the CSV file after a security check—to the last available index of the "$books" array.
                $books[] = $lineBook;
            }

            //An "if" code block that checks if the pointer file are not in the end of the CSV file. If so, it logs the error to "error.log" and throws an exception.
            if(feof($fileBooks) === false) {
                //Calling the function "error_log" to write a message of log in "error.log" more easily and to close the CSV file's pointer.
                error_log("[" . date("Y-m-d H:i:s") . "] ERROR: Failed while reading records from 'books.csv'." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");
                @fclose($fileBooks);

                //Throwing an exception with the message "READ_FILE" for indicate the error type.
                throw new Exception("READ_FILE");
            }

            //Closing the pointer "read" of the CSV file and assigning the return of the function responsible to close the file in a variable.
            $fileWasClosed = @fclose($fileBooks);

            //An "if" code block that checks if the pointer file are not closed. If don't, it logs the error to "error.log" and throws an exception.  
            if($fileWasClosed === false) {
                //Calling the function "error_log" to write a message of log in "error.log" more easily.
                error_log("[" . date("Y-m-d H:i:s") . "] WARNING: Could not properly close 'books.csv'." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");

                //Throwing an exception with the message "CLOSE_FILE" for indicate the error type.
                throw new Exception("CLOSE_FILE");
            }

            //Returning the array of books.
            return $books;
        }

        //Creating the "save" method, It is responsible to save the book's attributes in the CSV file in a row.
        public function save($title, $author, $year, $period, $status) {
            //Declaring variable: CSV file of the books(pointer to "append").
            $fileBooks = @fopen(__DIR__ . "/../data/books.csv", "a");

            //An "if" code block that checks if the file-opening function returned "false". If so, it logs the error to "error.log" and throws an exception.
            if($fileBooks === false) {
                //Calling the function "error_log" to write a message of log in "error.log" more easily.
                error_log("[" . date("Y-m-d H:i:s") . "] ERROR: Could not open 'books.csv' for append mode." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");

                //Throwing an exception with the message "CLOSE_FILE" for indicate the error type.
                throw new Exception("OPEN_FILE");
            }

            //Declaring variables: an array with the book's attributes, and the return of the function "fputcsv".
            $bookDatas = [$title, $author, $year . " " . $period, $status];
            $fileWasWritten = @fputcsv($fileBooks, $bookDatas, ",");

            //An "if" code block that checks if the file was written correctly with the book's attributes. If don't, it logs the error to "error.log" and throws an exception.
            if($fileWasWritten === false) {
                //Calling the function "error_log" and "fclose" to write a message of log in "error.log" more easily and to close the CSV file's pointer.
                error_log("[" . date("Y-m-d H:i:s") . "] ERROR: Failed to write data to 'books.csv'." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");
                @fclose($fileBooks);

                //Throwing an exception with the message "WRITE_FILE" for indicate the error type.
                throw new Exception("WRITE_FILE");
            }

            //Closing the pointer "append" of the CSV file and assigning the return of the function responsible to close the file in a variable.
            $fileWasClosed = @fclose($fileBooks);

            //An "if" code block that checks if the pointer file are not closed. If don't, it logs the error to "error.log" and throws an exception.
            if($fileWasClosed === false) {
                //Calling the function "error_log" to write a message of log in "error.log" more easily.
                error_log("[" . date("Y-m-d H:i:s") . "] WARNING: Could not properly close 'books.csv'." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");

                //Throwing an exception with the message "CLOSE_FILE" for indicate the error type.
                throw new Exception("CLOSE_FILE");
            }
        }

        public function remove($indexBook) {
            $fileBooks = fopen("../data/books.csv", "r");
            $indexActualBook = 0;
            $books = [];

            while(($lineBook = fgetcsv($fileBooks, 1000, ",")) != false) {
                if($indexActualBook != $indexBook) {
                    $books[] = $lineBook;   
                }

                $indexActualBook++;
            }

            fclose($fileBooks);

            $fileBooksEdited = fopen("../data/books.csv", "w");

            for($i = 0; $i < count($books); $i++) {
                fwrite($fileBooksEdited, $books[$i][0] . "," . $books[$i][1] . "," . $books[$i][2] . "," . $books[$i][3] . "\n");
            }

            fclose($fileBooksEdited);
        }

        public function search($indexBook) {
            $fileBooks = fopen("../data/books.csv", "r");
            $indexActualBook = 0;
            $bookToSearch = [];

            while(($lineBook = fgetcsv($fileBooks, 1000, ",")) != false) {
                if($indexActualBook == $indexBook) {
                    $bookToSearch = $lineBook;
                    break;
                }

                $indexActualBook++;
            }

            fclose($fileBooks);

            return $bookToSearch;
        }

        public function edit($indexBook, $title, $author, $year, $status) {
            $fileBooks = fopen("../data/books.csv", "r");
            $books = [];
            $indexActualBook = 0;

            while(($lineBook = fgetcsv($fileBooks, 1000, ",")) != false) {
                if($indexActualBook == $indexBook) {
                    $lineBook[0] = $title;
                    $lineBook[1] = $author;
                    $lineBook[2] = $year;
                    $lineBook[3] = $status;
                }

                $books[] = $lineBook;
                $indexActualBook++;
            }

            fclose($fileBooks);

            $fileBooksEdited = fopen("../data/books.csv", "w");

            for($i = 0; $i < count($books); $i++) {
                fwrite($fileBooksEdited, $books[$i][0] . "," . $books[$i][1] . "," . $books[$i][2] . "," . $books[$i][3] . "\n");
            }

            fclose($fileBooksEdited);
        }

        //Creating the "exists" method, It is responsible to check if the title and author attributes already exists in the database(books.csv). 
        public function exists($title, $author) {
            //Declaring variable: CSV file of the books(pointer to "read").
            $fileBooks = @fopen(__DIR__ . "/../data/books.csv", "r");

            //An "if" code block that checks if the file-opening function returned "false". If so, it logs the error to "error.log" and throws an exception.
            if($fileBooks === false) {
                //Calling the function "error_log" to write a message of log in "error.log" more easily.
                error_log("[" . date("Y-m-d H:i:s") . "] ERROR: Could not open 'books.csv' for duplicate-book verification." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");

                //Throwing an exception with the message "OPEN_FILE" for indicate the error type.
                throw new Exception("OPEN_FILE");
            }

            //A "while" code block, which will iterating through the CSV file to capturing the books and checking their titles and authors.
            while(($lineBook = @fgetcsv($fileBooks, 1000, ",")) != false) {
                //An "if" code block that checks whether the line containing the book is not corrupted and whether the book's title and author match the title and author passed to the verification method. If they match, the file pointer is closed and the function returns "true".
                if((count($lineBook) === 4) && ((mb_strtoupper($title, "UTF-8") === mb_strtoupper($lineBook[0], "UTF-8")) && (mb_strtoupper($author, "UTF-8") === mb_strtoupper($lineBook[1], "UTF-8")))) {
                    //Calling a function to close the CSV file's pointer.
                    @fclose($fileBooks);
                
                    //Due to the existence of a book with the same title and author passed to the verification method, the method returns "true".
                    return true;
                }
            }

            //An "if" code block that checks if the pointer file are not in the end of the CSV file. If so, it logs the error to "error.log" and throws an exception.
            if(feof($fileBooks) === false) {
                //Calling the functions "error_log" and "fclose" to write a message of log in "error.log" more easily and to close the CSV file's pointer.
                error_log("[" . date("Y-m-d H:i:s") . "] ERROR: Failed while reading 'books.csv' during duplicate-book verification." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");
                @fclose($fileBooks);

                //Throwing an exception with the message "READ_FILE_EXISTS" for indicate the error type.
                throw new Exception("READ_FILE_EXISTS");
            }

            //Closing the pointer "read" of the CSV file and assigning the return of the function responsible to close the file in a variable.
            $fileWasClosed = @fclose($fileBooks);

            //An "if" code block that checks if the pointer file are not closed. If don't, it logs the error to "error.log" and throws an exception.
            if($fileWasClosed === false) {
                //Calling the function "error_log" to write a message of log in "error.log" more easily.
                error_log("[" . date("Y-m-d H:i:s") . "] WARNING: Could not properly close 'books.csv' after duplicate-book verification." . PHP_EOL, 3, __DIR__ . "/../logs/error.log");

                //Throwing an exception with the message "CLOSE_FILE_EXISTS" for indicate the error type.
                throw new Exception("CLOSE_FILE_EXISTS");
            }

            //Having passed all the checks, the method returns "false".
            return false;
        }
    }