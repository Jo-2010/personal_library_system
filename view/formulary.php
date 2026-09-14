<h2 class="saveBookTitle">Save a book</h2>
<span id="messageSuccessWarningError" class="messageSuccessWarningError <?= $_SESSION['messageFormSave']['type'] ?? '' ?>"><?= $_SESSION['messageFormSave']['text'] ?? '' ?></span>
<form class="formSaveBook" id="formSaveBook" action="index.php?action=save" method="post" novalidate>
    <div class="labelInputUni">
        <label for="titleBook">Title:</label>
        <input type="text" name="title" value="<?= $_SESSION['oldValues']['title'] ?? '' ?>" class="<?= isset($_SESSION['errors']['title']) ? 'errorInput' : '' ?>" id="titleBook" minlength="1" maxlength="250" pattern="[\p{L}\p{N} .,;:!?&'\(\)\-]+" placeholder="Title of the book..." required>
        <span class="<?= isset($_SESSION['errors']['title']) ? 'errorMensageInput' : '' ?>"><?= $_SESSION['errors']['title'] ?? "" ?></span>   
    </div>
    <div class="labelInputUni">
        <label for="authorBook">Author(s):</label>
        <input type="text" name="author" value="<?= $_SESSION['oldValues']['author'] ?? '' ?>" class="<?= isset($_SESSION['errors']['author']) ? 'errorInput' : '' ?>" id="authorBook" minlength="2" maxlength="100" pattern="[\p{L}\p{M} .'\-]+" placeholder="Author(s) of this book..." required>
        <span class="<?= isset($_SESSION['errors']['author']) ? 'errorMensageInput' : '' ?>"><?= $_SESSION['errors']['author'] ?? "" ?></span>
    </div>
    <div class="labelInputUni">
        <label for="yearBook">Year:</label>
        <input type="text" name="year" value="<?= $_SESSION['oldValues']['year'] ?? '' ?>" class="<?= isset($_SESSION['errors']['year']) ? 'errorInput' : '' ?>" id="yearBook" placeholder="The book's release year..." required>
        <span class="<?= isset($_SESSION['errors']['year']) ? 'errorMensageInput' : '' ?>"><?= $_SESSION['errors']['year'] ?? "" ?></span>
    </div>
    <div class="labelInputUni">
        <label for="periodBook">Period:</label>
        <select name="period" class="<?= isset($_SESSION['errors']['period']) ? 'errorInput' : '' ?>" id="periodBook" required>
            <option value="" disabled <?= !isset($_SESSION['oldValues']['period']) ? 'selected' : '' ?>>Select one of these periods</option>
            <option class="optionSelectable" value="B.C." <?= isset($_SESSION['oldValues']['period']) && $_SESSION['oldValues']['period'] === "B.C." ? 'selected' : '' ?>>B.C.</option>
            <option class="optionSelectable" value="A.C." <?= isset($_SESSION['oldValues']['period']) && $_SESSION['oldValues']['period'] === "A.C." ? 'selected' : '' ?>>A.C.</option>
        </select>
        <span class="<?= isset($_SESSION['errors']['period']) ? 'errorMensageInput' : '' ?>"><?= $_SESSION['errors']['period'] ?? "" ?></span>
    </div>
    <div class="labelInputUni">
        <label for="statusBook">Status:</label>
        <select name="status" class="<?= isset($_SESSION['errors']['status']) ? 'errorInput' : '' ?>" id="statusBook" required>
            <option value="" disabled <?= !isset($_SESSION['oldValues']['status']) ? 'selected' : '' ?>>Select one of these status</option>
            <option class="optionSelectable" value="I want to read" <?= isset($_SESSION['oldValues']['status']) && $_SESSION['oldValues']['status'] === "I want to read" ? 'selected' : '' ?>>I want to read</option>
            <option class="optionSelectable" value="Reading" <?= isset($_SESSION['oldValues']['status']) && $_SESSION['oldValues']['status'] === "Reading" ? 'selected' : '' ?>>Reading</option>
            <option class="optionSelectable" value="Read" <?= isset($_SESSION['oldValues']['status']) && $_SESSION['oldValues']['status'] === "Read" ? 'selected' : '' ?>>Read</option>
        </select>
        <span class="<?= isset($_SESSION['errors']['status']) ? 'errorMensageInput' : '' ?>"><?= $_SESSION['errors']['status'] ?? "" ?></span>
    </div>
    <div class="submitEraseUni">
        <input type="submit" value="Submit">
        <input type="reset" value="Erase">
    </div>
</form>