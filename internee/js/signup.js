$(document).ready(function() {
    // Real-time validation for the name field
    $("#name").on("input", function() {
        var nameInput = $(this).val();
        var namePattern = /^[A-Za-z\s]+$/; // Alphabets and spaces only
        if (!namePattern.test(nameInput)) {
            $("#errName").text("Enter only alphabets Aa to Zz");
        } else {
            $("#errName").text("");
        }
    });
});
$(document).ready(function() {
    // Real-time validation for the Engineer field
    $("#ntn").on("input", function() {
        var ntnInput = $(this).val();
        var ntnPattern = /^\d{5}\/[A-Za-z]+$/; // Pattern: 12345/alphabets

        if (!ntnPattern.test(ntnInput)) {
            $("#errNtn").text("Pattern must be of 12345/alphabets");
        } else {
            $("#errNtn").text("");
        }
    });
});
$(document).ready(function() {
    // Real-time validation for the phone number field
    $("#phoneNo").on("input", function() {
       
        var phoneNumber = $(this).val();
        var phonePattern = /^\d{10}$/; // 13 digits only

        if (!phonePattern.test(phoneNumber)) {
          
            $("#errPhone").text("Enter a valid phone number with exactly 11 digits");
        } else {
            $("#errPhone").text(""); // Clear the error message when the input is valid
        }
    });
});
$(document).ready(function() {
   
    // Real-time validation for the CNIC number field
    $("#cnic").on("input", function() {
        var cnicInput = $(this).val();
        var cnicPattern = /^[\d-]+$/; // Digits and hyphens only

        if (!cnicPattern.test(cnicInput)) {
            $("#errCnic").text("CNIC number can only contain digits and hyphens");
            // Remove any non-digit or non-hyphen characters
            $(this).val(cnicInput.replace(/[^-\d]/g, ''));
        } else {
            $("#errCnic").text("");
        }
    });
});
$(document).ready(function() {
    // Real-time validation for the email address field
    $("#email").on("input", function() {
        var emailInput = $(this).val();
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        if (!emailPattern.test(emailInput)) {
            $("#errEmail").text("Enter a valid email address");
        } else {
            $("#errEmail").text("");
        }
    });
});

$(document).ready(function() {
    // Real-time validation for the date of birth and graduation year fields
    $("#dob, #gradYear").on("input", function() {
        var dobInput = $("#dob").val();
        var gradYearInput = $("#gradYear").val();
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();

        if (!/^\d{4}-\d{2}-\d{2}$/.test(dobInput)) {
            $("#errDob").text("Enter a valid date of birth (YYYY-MM-DD)");
        } else if (!/^\d{4}$/.test(gradYearInput)) {
            $("#errGradYear").text("Enter a valid graduation year (e.g., 2020)");
        } else {
            var inputYear = parseInt(dobInput.substring(0, 4));
            var gradYear = parseInt(gradYearInput);
            
            if (inputYear > currentYear) {
                $("#errDob").text("Enter a valid date of birth");
                $("#errGradYear").text("");
            } else if (gradYear <= inputYear + 20) {
                $("#errDob").text("");
                $("#errGradYear").text("Graduation year must be more than 20 years after your date of birth");
            } else {
                $("#errDob").text("");
                $("#errGradYear").text("");
            }
        }
    });
});
$(document).ready(function() {
    // Real-time validation for password and confirm password fields
    $("#password, #confirmPassword").on("input", function() {
        var passwordInput = $("#password").val();
        var confirmPasswordInput = $("#confirmPassword").val();

        // Password pattern: at least 8 characters, 1 digit, and 1 special character
        var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!passwordPattern.test(passwordInput)) {
            $("#errPassword").text("Password must be at least 8 characters long, with 1 digit and 1 special character.");
        } else {
            $("#errPassword").text("");
        }

        if (passwordInput !== confirmPasswordInput) {
            $("#confirmMessage").text("Passwords do not match.");
        } else {
            $("#confirmMessage").text("");
        }
    });
});










