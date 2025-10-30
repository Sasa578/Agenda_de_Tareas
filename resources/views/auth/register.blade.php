<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Agenda Universitaria</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Quicksand", sans-serif;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #3949ab 100%);
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-50px, -50px) rotate(360deg); }
        }

        .ring {
            position: relative;
            width: 500px;
            height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ring i {
            position: absolute;
            inset: 0;
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: 0.5s;
        }

        .ring i:nth-child(1) {
            border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
            animation: animate 6s linear infinite;
        }

        .ring i:nth-child(2) {
            border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
            animation: animate 4s linear infinite;
        }

        .ring i:nth-child(3) {
            border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
            animation: animate2 10s linear infinite;
        }

        .ring:hover i {
            border: 6px solid var(--clr);
            filter: drop-shadow(0 0 20px var(--clr));
        }

        @keyframes animate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes animate2 {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }

        .register {
            position: absolute;
            width: 400px;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
            z-index: 10;
        }

        .register h2 {
            font-size: 2.5em;
            color: #fff;
            font-weight: 500;
            text-align: center;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .register .subtitle {
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.1em;
        }

        .register .inputBx {
            position: relative;
            width: 100%;
        }

        .register .inputBx input {
            position: relative;
            width: 100%;
            padding: 15px 25px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 40px;
            font-size: 1.1em;
            color: #fff;
            box-shadow: none;
            outline: none;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .register .inputBx input:focus {
            border-color: #4caf50;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 20px rgba(76, 175, 80, 0.3);
        }

        .register .inputBx input[type="submit"] {
            width: 100%;
            background: linear-gradient(45deg, #4caf50, #43a047);
            border: none;
            cursor: pointer;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
            margin-top: 10px;
        }

        .register .inputBx input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.6);
            background: linear-gradient(45deg, #43a047, #4caf50);
        }

        .register .inputBx input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .register .links {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            margin-top: 10px;
        }

        .register .links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95em;
            transition: all 0.3s ease;
            position: relative;
        }

        .register .links a:hover {
            color: #fff;
            transform: translateY(-1px);
        }

        .register .links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background: #4caf50;
            transition: width 0.3s ease;
        }

        .register .links a:hover::after {
            width: 100%;
        }

        .logo {
            position: absolute;
            top: 30px;
            left: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 1.5em;
            font-weight: 600;
            z-index: 100;
        }

        .logo i {
            font-size: 1.8em;
            color: #4caf50;
        }

        .error-message {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid rgba(244, 67, 54, 0.3);
            color: #ffcdd2;
            padding: 12px 20px;
            border-radius: 10px;
            width: 100%;
            text-align: center;
            font-size: 0.95em;
            backdrop-filter: blur(10px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .ring {
                width: 350px;
                height: 350px;
            }
            
            .register {
                width: 320px;
            }
            
            .register h2 {
                font-size: 2em;
            }
            
            .logo {
                top: 20px;
                left: 20px;
                font-size: 1.2em;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px;
            }
            
            .ring {
                width: 300px;
                height: 300px;
            }
            
            .register {
                width: 280px;
            }
            
            .register h2 {
                font-size: 1.8em;
            }
            
            .register .inputBx input {
                padding: 12px 20px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="logo">
        <i class="fas fa-calendar-alt"></i>
        <span>Agenda Universitaria</span>
    </div>

    <!-- ring div starts here -->
    <div class="ring">
        <i style="--clr:#4caf50;"></i>
        <i style="--clr:#66bb6a;"></i>
        <i style="--clr:#81c784;"></i>
        <div class="register">
            <h2>Crear Cuenta</h2>
            <div class="subtitle">Comienza a organizar tus tareas</div>
            
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="inputBx">
                    <input type="text" name="name" placeholder="Nombre completo" value="{{ old('name') }}" required autofocus>
                </div>
                
                <div class="inputBx">
                    <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                </div>
                
                <div class="inputBx">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                
                <div class="inputBx">
                    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                </div>
                
                <div class="inputBx">
                    <input type="submit" value="Registrarse">
                </div>
            </form>

            <div class="links">
                <a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
    <!-- ring div ends here -->
</body>
</html>