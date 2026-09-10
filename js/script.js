//Declaring variables: DOM element(span) for the mensage of error or sucess in the save form, DOM element(input) for the book's title, DOM element(input) for the book's author, DOM element(input) for the book's publication year, Dropdown menu(select) for the reading period, Dropdown menu(select) for the book's status and the form element handling the save action.(formulary to save a book)
const spanMensageErrorSucess = document.getElementById("messageSuccessWarningError");
const inputTitleSave = document.getElementById("titleBook");
const inputAuthorSave = document.getElementById("authorBook");
const inputYearSave = document.getElementById("yearBook");
const selectPeriodSave = document.getElementById("periodBook");
const selectStatusSave = document.getElementById("statusBook");
const formSave = document.getElementById("formSaveBook");

//Calling the function "clearMessage" to clear the error, warning or success message from the form after a few seconds.
clearMessage(spanMensageErrorSucess);

//Attaching event listeners to handle continuous validation of user input in form fields (inputs and selects), form submission (triggering a general validation), and form clearing (resetting all field errors, etc.).
inputTitleSave.addEventListener("input", () => {
    //Calling the "validateTitle" function to validate the text of an HTML input as a title.
    validateTitle(inputTitleSave);
});
inputAuthorSave.addEventListener("input", () => {
    //Calling the "validateAuthor" function to validate the text of an HTML input as a author.
    validateAuthor(inputAuthorSave);
});
inputYearSave.addEventListener("input", () => {
    //Calling the "validateYear" function to validate the text of an HTML input as a year.
    validateYear(inputYearSave);
});
selectPeriodSave.addEventListener("change", () => {
    validateYear(inputYearSave);
    validatePeriod(selectPeriodSave);
    changeColorOptionSelected(selectPeriodSave);
});
selectStatusSave.addEventListener("change", () => {
    validateStatus(selectStatusSave);
    changeColorOptionSelected(selectStatusSave);
});
formSave.addEventListener("submit", (event) => {
    validateFormSave(event);
});
formSave.addEventListener("reset", () => {
    setTimeout(() => {
        cleanAllFormFieldsErrors();
        changeColorOptionSelected(selectPeriodSave);
        changeColorOptionSelected(selectStatusSave);
    }, 0);
});

//Creating the "clearMessage" function, which clears the text of an HTML element after 4 seconds.
function clearMessage(spanMensage) {
    setTimeout(() => {
        spanMensage.textContent = "";
    }, 4000);
}

//Creating the "changeColorOptionSelected" function, which sets the correct color for the selected option in a `<select>` tag within an HTML form.
function changeColorOptionSelected(selectForm) {
    if(selectForm.value === "") {
        selectForm.style.color = "#767676";
    } else {
        selectForm.style.color = "#000000";
    }
}

//Creating the "validateTitle" function, which is responsible for validating the input title text through various checks; it styles the form field and displays an error message and returning "false" if an issue is found, or clears the error and message and returning "true" if everything is correct.
function validateTitle(inputToValidate) {
    //An "if-else if-else" code block responsible for containing all validation checks for a book title.
    if(inputToValidate.value.length === 0) {
        implementErrorFormField(inputToValidate, "Title is Required.");

        return false;
    } else if(inputToValidate.value.trim().length === 0) {
        implementErrorFormField(inputToValidate, "Title cannot contain only spaces.");
        
        return false;
    } else if(inputToValidate.value.trim().length > 250) {
        implementErrorFormField(inputToValidate, "Title cannot exceed 250 characters.");
       
        return false;
    } else if(inputToValidate.validity.patternMismatch) {
        implementErrorFormField(inputToValidate, "Title contains invalid characters.");
        
        return false;
    } else {
        cleanFormFieldError(inputToValidate);
        
        return true;
    }
}

function validateAuthor(inputToValidate) {
    if(inputToValidate.value.length === 0) {
        implementErrorFormField(inputToValidate, "Author is Required.");
        
        return false;
    } else if(inputToValidate.value.trim().length === 0) {
        implementErrorFormField(inputToValidate, "Author cannot contain only spaces.");
        
        return false;
    } else if(inputToValidate.value.trim().length < 2) {
        implementErrorFormField(inputToValidate, "Author cannot contain fewer than 2 characters.");
        
        return false;
    } else if(inputToValidate.value.trim().length > 100) {
        implementErrorFormField(inputToValidate, "Author cannot exceed 100 characters.");
        
        return false;
    } else if(inputToValidate.validity.patternMismatch) {
        implementErrorFormField(inputToValidate, "Author contains invalid characters.");
        
        return false;
    } else {
        cleanFormFieldError(inputToValidate);
        
        return true;
    }
}

function validateYear(inputToValidate) {
    if(inputToValidate.value.length === 0) {
        implementErrorFormField(inputToValidate, "Year is Required.");
        
        return false;
    } else if(inputToValidate.value.trim().length === 0) {
        implementErrorFormField(inputToValidate, "Year cannot contain only spaces.");
        
        return false;
    } else if(Number(inputToValidate.value) <= 0) {
        implementErrorFormField(inputToValidate, "Year must be a positive, non-null integer.");
        
        return false;
    } else if(/[^0-9.,]/.test(inputToValidate.value)) {
        implementErrorFormField(inputToValidate, "Year must be numeric.");
        
        return false;
    } else if(/^0[0-9]+/.test(inputToValidate.value)) {
        implementErrorFormField(inputToValidate, "Year cannot contain leading zeros.");
        
        return false;
    } else if(/[.,]/.test(inputToValidate.value)) {
        implementErrorFormField(inputToValidate, "Year must be an integer.");
        
        return false;
    } else if(selectPeriodSave.value === "B.C." && Number(inputToValidate.value) > 3300) {
        implementErrorFormField(inputToValidate, "Invalid year for the period B.C.");
        
        return false;
    } else if(selectPeriodSave.value === "A.C." && Number(inputToValidate.value) > new Date().getFullYear()) {
        implementErrorFormField(inputToValidate, "Invalid year for the period A.C.");
        
        return false;
    } else {
        cleanFormFieldError(inputToValidate);
        
        return true;
    }
}

function validatePeriod(selectToValidate) {
    if(selectToValidate.value.trim() !== "B.C." && selectToValidate.value.trim() !== "A.C.") {
        implementErrorFormField(selectToValidate, "Select the historical period.");
        
        return false;
    } else {
        cleanFormFieldError(selectToValidate);
        
        return true;
    }
}

function validateStatus(selectToValidate) {
    if(selectToValidate.value.trim() !== "I want to read" && selectToValidate.value.trim() !== "Reading" && selectToValidate.value.trim() !== "Read") {
        implementErrorFormField(selectToValidate, "Select the book's status.");
        
        return false;
    } else {
        cleanFormFieldError(selectToValidate);
        
        return true;
    }
}

function validateFormSave(event) {
    const validatedTitle = validateTitle(inputTitleSave);
    const validatedAuthor = validateAuthor(inputAuthorSave);
    const validatedYear = validateYear(inputYearSave);
    const validatedPeriod = validatePeriod(selectPeriodSave);
    const validatedStatus = validateStatus(selectStatusSave);

    if(!(validatedTitle && validatedAuthor && validatedYear && validatedPeriod && validatedStatus)) {
        event.preventDefault();
    }
}

function implementErrorFormField(formField, errorMensage) {
    formField.classList.add("errorInput");
    formField.nextElementSibling.textContent = errorMensage;
    formField.nextElementSibling.classList.add("errorMensageInput");
}

//Functions to clean form field errors in the save formulary.
function cleanFormFieldError(formField) {
    formField.classList.remove("errorInput");
    formField.nextElementSibling.textContent = "";
    formField.nextElementSibling.classList.remove("errorMensageInput");
}

function cleanAllFormFieldsErrors() {
    const inputsSelects = document.querySelectorAll('#formSaveBook input:not([type="submit"]):not([type="reset"]), #formSaveBook select');

    inputsSelects.forEach((formField) => {
        cleanFormFieldError(formField);
    });
}