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

//Attaching event listeners to handle continuous validation of user input in form fields(inputs and selects), form submission(triggering a general validation), and form clearing(resetting all field errors, etc.).
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
    //Calling the functions "validateYear", "validatePeriod", and "changeColorOptionSelected" to, respectively, validate the period text from the HTML select, validate the year text from the HTML input, and change the color of the selected option in an HTML select element.
    validatePeriod(selectPeriodSave);
    validateYear(inputYearSave);
    changeColorOptionSelected(selectPeriodSave);
});
selectStatusSave.addEventListener("change", () => {
    //Calling the functions "validateStatus" and "changeColorOptionSelected" to, respectively, validate the status text from the HTML input and change the color of the selected option in an HTML select element.
    validateStatus(selectStatusSave);
    changeColorOptionSelected(selectStatusSave);
});
formSave.addEventListener("submit", (event) => {
    //Calling the "validateFormSave" function to trigger validation for all fields and determine whether to proceed with form submission.
    validateFormSave(event);
});
formSave.addEventListener("reset", () => {
    //Calling the "setTimeout" function so that the form fields are cleared first, and only then the code block is executed.
    setTimeout(() => {
        //Calling the functions "cleanAllFormFieldsErrors" and—twice—"changeColorOptionSelected" to clear error styling on form fields when resetting the form, and to revert the colors to the original option for two HTML select elements.
        cleanAllFormFieldsErrors();
        changeColorOptionSelected(selectPeriodSave);
        changeColorOptionSelected(selectStatusSave);
    }, 0);
});

//Creating the "clearMessage" function, which clears the text of an HTML element after 4 seconds.
function clearMessage(spanMessage) {
    //Calling the "setTimeout" function to execute a block of code after 4 seconds.
    setTimeout(() => {
        //Applying nothing as the text content of a "span" tag.
        spanMessage.textContent = "";
    }, 4000);
}

//Creating the "changeColorOptionSelected" function, which sets the correct color for the selected option in a `<select>` tag within an HTML form.
function changeColorOptionSelected(selectForm) {
    //An "if-else" code block responsible for applying a gray color to the current option of a select tag if its value is empty; otherwise, the color applied to the current option is black.
    if(selectForm.value === "") {
        //Applying the hexadecimal color "#767676" to the "color" property of the HTML select element.
        selectForm.style.color = "#767676";
    } else {
        //Applying the hexadecimal color "#000000" to the "color" property of the HTML select element.
        selectForm.style.color = "#000000";
    }
}

//Creating the "validateTitle" function, which is responsible for validating the input title text through various checks; it styles the form field and displays an error message and returning "false" if an issue is found, or clears the error and message and returning "true" if everything is correct.
function validateTitle(inputToValidate) {
    //An "if-else if-else" code block responsible for containing all validation checks for a book title.
    if(inputToValidate.value.length === 0) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Title is Required.");

        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.value.trim().length === 0) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Title cannot contain only spaces.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.value.trim().length > 250) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Title cannot exceed 250 characters.");
       
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.validity.patternMismatch) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Title contains invalid characters.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else {
        //Calling the "cleanFormFieldError" function, which removes the styling and error message from a form field.
        cleanFormFieldError(inputToValidate);
        
        //Due to a validation, the function returns "true".
        return true;
    }
}

//Creating the "validateAuthor" function, which is responsible for validating the input author text through various checks; it styles the form field and displays an error message and returning "false" if an issue is found, or clears the error and message and returning "true" if everything is correct.
function validateAuthor(inputToValidate) {
    //An "if-else if-else" code block responsible for containing all validation checks for a book author.
    if(inputToValidate.value.length === 0) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Author is Required.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.value.trim().length === 0) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Author cannot contain only spaces.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.value.trim().length < 2) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Author cannot contain fewer than 2 characters.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.value.trim().length > 100) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Author cannot exceed 100 characters.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.validity.patternMismatch) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Author contains invalid characters.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else {
        //Calling the "cleanFormFieldError" function, which removes the styling and error message from a form field.
        cleanFormFieldError(inputToValidate);
        
        //Due to a validation, the function returns "true".
        return true;
    }
}

//Creating the "validateYear" function, which is responsible for validating the input year text through various checks; it styles the form field and displays an error message and returning "false" if an issue is found, or clears the error and message and returning "true" if everything is correct.
function validateYear(inputToValidate) {
    //An "if-else if-else" code block responsible for containing all validation checks for a book year.
    if(inputToValidate.value.length === 0) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Year is Required.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(inputToValidate.value.trim().length === 0) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Year cannot contain only spaces.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(Number(inputToValidate.value) <= 0) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Year must be a positive, non-null integer.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(/[^0-9.,]/.test(inputToValidate.value)) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Year must be numeric.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(/^0[0-9]+/.test(inputToValidate.value)) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Year cannot contain leading zeros.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(/[.,]/.test(inputToValidate.value)) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Year must be an integer.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(selectPeriodSave.value === "B.C." && Number(inputToValidate.value) > 3300) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Invalid year for the period B.C.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else if(selectPeriodSave.value === "A.C." && Number(inputToValidate.value) > new Date().getFullYear()) {
        //Calling the "implementErrorFormField" function, which takes the HTML input and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(inputToValidate, "Invalid year for the period A.C.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else {
        //Calling the "cleanFormFieldError" function, which removes the styling and error message from a form field.
        cleanFormFieldError(inputToValidate);
        
        //Due to a validation, the function returns "true".
        return true;
    }
}

//Creating the "validatePeriod" function, which is responsible for validating the select period text through a check; it styles the form field and displays an error message and returning "false" if an issue is found, or clears the error and message and returning "true" if everything is correct.
function validatePeriod(selectToValidate) {
    //An "if-else" code block responsible for containing all validation checks for a book period.
    if(selectToValidate.value.trim() !== "B.C." && selectToValidate.value.trim() !== "A.C.") {
        //Calling the "implementErrorFormField" function, which takes the HTML select and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(selectToValidate, "Select the historical period.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else {
        //Calling the "cleanFormFieldError" function, which removes the styling and error message from a form field.
        cleanFormFieldError(selectToValidate);
        
        //Due to a validation, the function returns "true".
        return true;
    }
}

//Creating the "validateStatus" function, which is responsible for validating the select status text through a check; it styles the form field and displays an error message and returning "false" if an issue is found, or clears the error and message and returning "true" if everything is correct.
function validateStatus(selectToValidate) {
    //An "if-else" code block responsible for containing all validation checks for a book status.
    if(selectToValidate.value.trim() !== "I want to read" && selectToValidate.value.trim() !== "Reading" && selectToValidate.value.trim() !== "Read") {
        //Calling the "implementErrorFormField" function, which takes the HTML select and an error message and applies the appropriate error styling to the form field.
        implementErrorFormField(selectToValidate, "Select the book's status.");
        
        //Due to an invalidation, the function returns "false".
        return false;
    } else {
        //Calling the "cleanFormFieldError" function, which removes the styling and error message from a form field.
        cleanFormFieldError(selectToValidate);
        
        //Due to a validation, the function returns "true".
        return true;
    }
}

//Creating the "validateFormSave" function, which is responsible for calling all other functions that validate book attributes, storing their boolean return values ​​in variables, and preventing the form from being submitted if any of them return "false".
function validateFormSave(event) {
    //Declaring variables: the boolean return values ​​from each of the book attribute validation functions, based on the current contents of the corresponding HTML input and select elements.
    const validatedTitle = validateTitle(inputTitleSave);
    const validatedAuthor = validateAuthor(inputAuthorSave);
    const validatedYear = validateYear(inputYearSave);
    const validatedPeriod = validatePeriod(selectPeriodSave);
    const validatedStatus = validateStatus(selectStatusSave);

    //An "if" code block that checks whether any of the variables returned "false." If so, the form submission event is prevented; otherwise, the form is submitted normally.
    if(!(validatedTitle && validatedAuthor && validatedYear && validatedPeriod && validatedStatus)) {
        //Cancels the event's default behavior(prevents form submission).
        event.preventDefault();
    }
}

//Creating the "implementErrorFormField" function, which takes the form field and an error message to add the corresponding error classes to the form field and "span" tags and display the message.
function implementErrorFormField(formField, errorMessage) {
    //Adding the error styling class to the form field, adding the error message in the "span" tag, and adding the error class to the "span" tag within the message.
    formField.classList.add("errorInput");
    formField.nextElementSibling.textContent = errorMessage;
    formField.nextElementSibling.classList.add("errorMessageInput");
}

//Creating the "cleanFormFieldError" function, which takes a form field, removes its error styling, and clears the error message styling and text.
function cleanFormFieldError(formField) {
    //Removing the error styling class in the form field, removing the error message in the "span" tag, and removing the error class in the "span" tag of the message.
    formField.classList.remove("errorInput");
    formField.nextElementSibling.textContent = "";
    formField.nextElementSibling.classList.remove("errorMessageInput");
}

//Creating the "cleanAllFormFieldsErrors" function, which takes all the form fields for saving a book and repeatedly calls the "cleanFormFieldError" function for each form field stored in the variable.
function cleanAllFormFieldsErrors() {
    //Declaring a variable: DOM elements containing all the form fields for saving a book, using a CSS selector.
    const inputsSelects = document.querySelectorAll('#formSaveBook input:not([type="submit"]):not([type="reset"]), #formSaveBook select');

    //Using the "forEach" method to iterate over the "nodeList" and remove the styling from each HTML form field, based on the code block passed as a parameter.
    inputsSelects.forEach((formField) => {
        //Calling the "cleanForm FieldError" function, which takes an HTML form field and removes the error styling from it.
        cleanFormFieldError(formField);
    });
}