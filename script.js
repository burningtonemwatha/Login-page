document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const errorMessage = document.getElementById("error-message");
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    // Prevent form submission if inputs are empty
    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            const username = document.getElementById("username").value.trim();
            const password = passwordInput.value.trim();

            if (username === "" || password === "") {
                event.preventDefault();
                errorMessage.textContent = "Please fill in all fields.";
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener("submit", function(event) {
            const username = document.getElementById("username").value.trim();
            const password = passwordInput.value.trim();

            if (username.length < 3) {
                event.preventDefault();
                errorMessage.textContent = "Username must be at least 3 characters long.";
            } else if (password.length < 6) {
                event.preventDefault();
                errorMessage.textContent = "Password must be at least 6 characters long.";
            }
        });
    }

    // Show/Hide password toggle
    if (togglePassword) {
        togglePassword.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.textContent = "Hide";
            } else {
                passwordInput.type = "password";
                togglePassword.textContent = "Show";
            }
        });
    }

    // AJAX username availability check
    const usernameInput = document.getElementById("username");
    const usernameStatus = document.getElementById("username-status");

    if (usernameInput) {
        usernameInput.addEventListener("input", function() {
            let username = usernameInput.value.trim();
            if (username.length > 0) {
                fetch(`check_username.php?username=${username}`)
                    .then(response => response.text())
                    .then(data => {
                        usernameStatus.textContent = data;
                    });
            } else {
                usernameStatus.textContent = "";
            }
        });
    }
});
