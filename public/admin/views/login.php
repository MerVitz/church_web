<?php
$message = "";

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

include_once __DIR__ . '/../../../includes/db.php';

$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']);

function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="/public/css/index.css">
    </head>
    <body class="min-h-screen bg-gradient-to-r from-[#6C8BC9] to-[#D18C7C] relative">

    <!-- Back to Site -->
    <a href="/" 
    class="absolute top-4 left-4 px-3 py-1 text-sm bg-white/10 text-white font-medium rounded-md hover:bg-white/20 transition">
        ← Back to Site
    </a>


        <?php if (!empty($message)) : ?>
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="flex justify-center px-4">
            <div class="relative w-[80%] max-w-lg mx-auto bg-white/10 backdrop-blur-md p-8 rounded-xl shadow-lg mt-36 mb-16">
                <h2 class="text-2xl font-bold text-white text-center mb-6">Admin Login</h2>

                <!-- Error Message Display -->
                <?php if (!empty($errorMessage)): ?>
                <div class="bg-red-200 text-red-800 border border-red-400 px-4 py-2 rounded-lg shadow-md text-center font-semibold mb-4">
                    <?= htmlspecialchars($errorMessage) ?>
                </div>
                <?php endif; ?>

                <form id="login-form" class="space-y-4" method="POST" action="/admin/auth.php">
                    <!-- Username -->
                    <div>
                        <label for="username" class="text-white font-semibold">Username</label>
                        <input type="text" id="username" name="username"
                            class="w-full px-4 py-2 border border-white rounded-lg bg-white/30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-[#d4963a]"
                            placeholder="Enter username" required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="text-white font-semibold">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2 border border-white rounded-lg bg-white/30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-[#d4963a]"
                                placeholder="Enter password" required>

                            <!-- Eye Icon -->
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- CSRF -->
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken(); ?>">

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 px-6 bg-gradient-to-r from-[#6C8BC9] to-[#D18C7C] text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
                        <span class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884l8 4.8a1 1 0 001.004 0l8-4.8A1 1 0 0018.999 4H1a1 1 0 001.003 1.884z" />
                                <path d="M19 8.118l-7.997 4.797a1 1 0 01-1.006 0L3 8.118V14a1 1 0 001 1h12a1 1 0 001-1V8.118z" />
                            </svg>
                            <span>Login</span>
                        </span>
                    </button>
                </form>

                <p class="text-center text-white text-sm mt-4">
                    &copy; <?= date("Y"); ?> ACK All Saints Maseno Parish. All Rights Reserved.
                </p>
            </div>
        </div>


        <script>
            document.getElementById("login-form").addEventListener("submit", async function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const errorMessage = document.getElementById("error-message");

                try {
                    const response = await fetch("/public/admin/auth.php", {
                        method: "POST",
                        body: formData
                    });

                    const result = await response.json();

                    if (result.error) {
                        if (!errorMessage) {
                            const errorDiv = document.createElement("div");
                            errorDiv.id = "error-message";
                            errorDiv.classList.add("text-red-500", "text-center", "font-semibold", "mb-3");
                            errorDiv.textContent = result.error;
                            this.insertAdjacentElement("beforebegin", errorDiv);
                        } else {
                            errorMessage.textContent = result.error;
                            errorMessage.classList.remove("hidden");
                        }
                    } else if (result.success) {
                        window.location.href = result.redirect;
                    }
                } catch (error) {
                    console.error("Login error:", error);
                    errorMessage.textContent = "Something went wrong. Please try again.";
                    errorMessage.classList.remove("hidden");
                }
            });

            function togglePassword() {
                const passwordInput = document.getElementById("password");
                const eyeIcon = document.getElementById("eyeIcon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7 1.274-4.057 5.065-7 9.542-7 1.34 0 2.623.244 3.825.688m3.853 2.32a9.978 9.978 0 012.017 3.992c-1.274 4.057-5.065 7-9.542 7-1.34 0-2.623-.244-3.825-.688m-.658-1.163A9.978 9.978 0 012.458 12M6 18L18 6"/>
                    `;
                } else {
                    passwordInput.type = "password";
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    `;
                }
            }

        </script>
    </body>
</html>

