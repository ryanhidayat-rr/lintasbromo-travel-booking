<!-- loading.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loading...</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #fefefe, #f3f3f3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .logo-loader {
            width: 100px;
            animation: floatSpinGlow 3s ease-in-out infinite;
            margin-bottom: 25px;
            filter: drop-shadow(0 0 10px rgba(221, 125, 16, 0.6));
        }

        @keyframes floatSpinGlow {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                filter: drop-shadow(0 0 10px rgba(221, 125, 16, 0.5));
            }
            50% {
                transform: translateY(-15px) rotate(3deg);
                filter: drop-shadow(0 0 25px rgba(221, 125, 16, 0.8));
            }
        }

        .loading-text {
            font-size: 18px;
            color: #444;
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
            animation-delay: 0.5s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>

    <script>
        // Redirect otomatis setelah 3 detik
        setTimeout(function(){
            window.location.href = "history.php";
        }, 3000);
    </script>
</head>
<body>
    <!-- Ganti src dengan logo kamu -->
    <img src="gambar/logo-lintasbenua.png" alt="Loading..." class="logo-loader">
    <p class="loading-text">Processing your request...</p>
</body>
</html>
