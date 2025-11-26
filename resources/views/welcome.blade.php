<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Electro</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body, html {
            height: 100%;
            background: linear-gradient(135deg, #4371F0FF, #51F051FF);
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start; /* Sedikit ke kiri */
            height: 100%;
            padding-left: 10%; /* Jarak dari kiri */
            color: rgb(57, 116, 151);
        }

        .container h1 {
            font-size: 3rem;
            margin-bottom: 30px;
        }

        .buttons {
            display: flex;
            gap: 20px;
        }

        .buttons a {
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .login-btn {
            background-color: rgb(48, 37, 37);
            color: #1DFDF2FF;
        }

        .login-btn:hover {
            background-color: #ffe0b2;
        }

        .register-btn {
            background-color: transparent;
            border: 2px solid rgb(20, 218, 191);
            color: rgb(39, 238, 145);
        }

        .register-btn:hover {
            background-color: white;
            color: #ff8c00;
        }

        /* Responsif untuk mobile */
        @media (max-width: 768px) {
            .container h1 {
                font-size: 2rem;
            }

            .buttons {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Electro</h1>
        <div class="buttons">
            <a href="/login" class="login-btn">Login</a>
            <a href="/register" class="register-btn">Register</a>
        </div>
    </div>
</body>
</html>
