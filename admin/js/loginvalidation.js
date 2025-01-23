// Function to validate the form and redirect on successful validation
function validateForm() {
  var email = document.getElementsByName("email")[0].value.trim();
  var password = document.getElementsByName("password")[0].value;

  // Validate email format
  var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
  if (!emailRegex.test(email)) {
    alert("Invalid email format");
    return false;
  }

  // Validate password
  if (password === "") {
    alert("Password is required");
    return false;
  }

  // Form is valid, redirect to empDashboard.php
  window.location.href = "adminDashboard.php";
  return false; // Prevent form submission (optional)
}

// Attach event listener to the submit button
var submitButton = document.querySelector("button[name='submit']");
submitButton.addEventListener("click", validateForm);
