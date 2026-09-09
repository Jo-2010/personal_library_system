//Declaring variables: DOM element(span) for the mensage of error or sucess in the save form, DOM element(input) for the book's title, DOM element(input) for the book's author, DOM element(input) for the book's publication year, Dropdown menu(select) for the reading period, Dropdown menu(select) for the book's status and the form element handling the save action.(formulary to save a book)
const spanMensageErrorSucess = document.getElementById("messageSuccessWarningError");
const inputTitleSave = document.getElementById("titleBook");
const inputAuthorSave = document.getElementById("authorBook");
const inputYearSave = document.getElementById("yearBook");
const selectPeriodSave = document.getElementById("periodBook");
const selectStatusSave = document.getElementById("statusBook");
const formSave = document.getElementById("formSaveBook");

//Calling a function to clear the error, warning success message from the form after a few seconds.
clearMensage(spanMensageErrorSucess);

function clearMensage(spanMensage) {
    setTimeout(() => {
        spanMensage.textContent = "";
    }, 4000);
}

//Constant validation in inputs, selects and formulary's submit in the save formulary.
inputTitleSave.addEventListener("input", () => {
    validateTitle(inputTitleSave);
});
inputAuthorSave.addEventListener("input", () => {
    validateAuthor(inputAuthorSave);
});
inputYearSave.addEventListener("input", () => {
    validateYear(inputYearSave);
});
selectPeriodSave.addEventListener("change", () => {
    validateYear(inputYearSave);
    validatePeriod(selectPeriodSave);
});
selectStatusSave.addEventListener("change", () => {
    validateStatus(selectStatusSave);
});
formSave.addEventListener("submit", (event) => {
    validateFormSave(event);
});

//Change color in the selected option in the save formulary of period and status of the book.
selectPeriodSave.addEventListener("change", () => {
    changeColorOptionSelected(selectPeriodSave);
});
selectStatusSave.addEventListener("change", () => {
    changeColorOptionSelected(selectStatusSave);
});
formSave.addEventListener("reset", () => {
    setTimeout(() => {
        cleanAllFormFieldsErrors();
        changeColorOptionSelected(selectPeriodSave);
        changeColorOptionSelected(selectStatusSave);
    }, 0);
});

function changeColorOptionSelected(selectForm) {
    if(selectForm.value === "") {
        selectForm.style.color = "#767676";
    } else {
        selectForm.style.color = "black";
    }
}

//Functions to validate and invalidate form fields in save formulary.
function validateTitle(inputToValidate) {
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