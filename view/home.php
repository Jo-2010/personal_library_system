<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calligraffitti&family=EB+Garamond:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="img/rustic_books.png">
    <link rel="stylesheet" href="css/style.css">
    <title>Personal library</title>
</head>
<body class="<?= isset($_SESSION['possibleDuplicate'], $_SESSION['oldValues']) ? "modalOpen" : '' ?>">
    <h1 id="mainTitleLibrary" class="mainTitleLibrary">Personal library</h1>
    <?= !empty($books) ? '<a href="#titleFormSaveBook" class="redirectLink">"Go to the form for saving a book"</a>' : "" ?>
    <?php
        //Adding, in a non-necessary manner, the "table.php" and "formulary.php" files to display the books and make the form for saving a book available, and destroying the following associative indices of the "$_SESSION" superglobal variable: "errors", "oldValues", "messageTableBooks", and "messageFormSave".
        include __DIR__ . "/table.php";
        include __DIR__ . "/formulary.php";
    ?>
    <?php if(isset($_SESSION['possibleDuplicate'], $_SESSION['oldValues'])): ?>
        <div class="duplicateOverlay">
            <form action="index.php?action=confirmSave" method="post" class="duplicateConfirmation">
                <h2 class="warning">Warning: possible duplicate book</h2>
                <div class="textsPossibleDuplicate">
                    <p>A book with the same title and author is already registered in your library:</p>
                    <div class="titleAuthorDuplicate">
                        <span>TITLE: <?= $_SESSION['oldValues']['title'] ?></span>
                        <span>AUTHOR: <?= $_SESSION['oldValues']['author'] ?></span>
                    </div>
                    <p>This may be another copy in this bookshelf/table, edition, translation or version of the same work. Are you sure you want to add this book?</p>
                </div>
                <div class="duplicateActions">
                    <input type="submit" class="inputCancel" name="cancel" value="Cancel">
                    <input type="submit" class="inputAddAnyway" name="addAnyway" value="Add anyway">
                </div>
            </form>
        </div>
    <?php endif; ?>
    <?php
        //Resetting the 'errors', 'messageTableBooks', and 'messageFormSave' associative keys within the '$_SESSION' superglobal from scratch.
        unset($_SESSION['errors'], $_SESSION['messageTableBooks'], $_SESSION['messageFormSave']);
        
        //An "if" code block which sees if the associative key 'possibleDuplicate' of the superglobal "$_SESSION" was not initialized. if wasn't, it will reset the associative key 'oldValues' in the superglobal "$_SESSION".
        if(!isset($_SESSION['possibleDuplicate'])) {
            //Resetting the 'oldValues' associative key in the superglobal "$_SESSION".
            unset($_SESSION['oldValues']);
        }
    ?>
    <script src="js/script.js"></script>
</body>
</html>