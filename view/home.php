<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calligraffitti&family=EB+Garamond:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="icon" href="img/rustic_books.png">
    <link rel="stylesheet" href="css/style.css">
    <title>Personal library</title>
</head>
<body class="modalOpen">
    <h1 class="mainTitleLibrary">Personal library</h1>
    <?php
        //Adding, in a non-necessary manner, the "table.php" and "formulary.php" files to display the books and make the form for saving a book available, and destroying the following associative indices of the "$_SESSION" superglobal variable: "errors", "oldValues", "messageTableBooks", and "messageFormSave".
        include __DIR__ . "/table.php";
        include __DIR__ . "/formulary.php";
        unset($_SESSION['errors']);
        unset($_SESSION['oldValues']);
        unset($_SESSION['messageTableBooks']);
        unset($_SESSION['messageFormSave']);
    ?>
    <div class="duplicateOverlay">
        <form action="" class="duplicateConfirmation">
            <h2 class="warning">Warning: possible duplicate book</h2>
            <div class="textsPossibleDuplicate">
                <p>A book with the same title and author is already registered in your library:</p>
                <div class="titleAuthorDuplicate">
                    <span>TITLE: Diary of a Wimpy Kid</span>
                    <span>AUTHOR: Jeff Kinney</span>
                </div>
                <p>This may be another edition, translation or version of the same work. Are you sure you want to add this book?</p>
            </div>
            <div class="duplicateActions">
                <input type="submit" class="inputCancel" value="Cancel">
                <input type="submit" class="inputAddAnyway" value="Add anyway">
            </div>
        </form>
    </div>
    <script src="js/script.js"></script>
</body>
</html>