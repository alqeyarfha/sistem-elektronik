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
            background: linear-gradient(135deg, #4371F0FF, #F2F5F2FF);
        }

        .main-content {
            display: flex;
            height: 100vh;
        }

        .left-side {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-left: 8%;
            padding-right: 2%;
            color: #FFFFFF;
        }

        .left-side h1 {
            font-size: 3rem;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
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
            text-align: center;
        }

        .login-btn {
            background-color: rgb(48, 37, 37);
            color: #1DFDF2FF;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .login-btn:hover {
            background-color: #fffffe;
            color: rgb(48, 37, 37);
        }

        .register-btn {
            background-color: transparent;
            border: 2px solid rgb(20, 218, 191);
            color: rgb(39, 238, 145);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .register-btn:hover {
            background-color: white;
            color: #f3f2f1;
            border-color: #fcfbf9;
        }

        .right-side {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .hero-image {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 90px;
            box-shadow: 0 10px 90px rgb(2, 125, 241);
            object-fit: contain;

            /* Animasi Melayang */
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, -15px); }
            100% { transform: translate(0, 0px); }
        }


        @media (max-width: 1024px) {
            .main-content {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }

            .left-side, .right-side {
                width: 100%;
                padding: 5% 5%;
            }

            .left-side {
                min-height: 50vh;
                align-items: center;
                text-align: center;
            }
            .left-side h1 {
                font-size: 2.5rem;
            }

            .right-side {
                padding: 0 5% 5% 500%;
            }

            .buttons {
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }
            .buttons a {
                width: 100%;
            }

            .hero-image {
                max-height: 60vh;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">

        <div class="left-side">
            <h1>Selamat Datang di Toko Electro</h1>
            <div class="buttons">
                <a href="/login" class="login-btn">Login</a>
                <a href="/register" class="register-btn">Register</a>
            </div>
        </div>

        <div class="right-side">
            <img src="../assets/img/avatars/3.jpeg" alt="Gambar Ilustrasi Produk Electro" class="hero-image">
        </div>

    </div>
</body>
</html>
