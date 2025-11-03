<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | SITAMA</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      margin: 0;
      background-color: #f7f8fc;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      padding: 20px;
    }

    /* Center wrapper for the form */
    .center-wrap {
      width: 100%;
      max-width: 420px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-box {
      width: 100%;
      max-width: 380px;
      padding: 28px;
      box-shadow: 0 6px 18px rgba(44,62,80,0.08);
      border-radius: 10px;
      background-color: white; /* keep only the box white */
    }

    /* Responsive: ensure the centered layout works on small screens */
    @media (max-width: 480px) {
      body {
        padding: 12px;
      }
      .login-box {
        padding: 18px;
      }
    }

    .logo {
      display: block;
      margin: 0 auto 10px;
      width: 80px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #2c3e50;
    }

    label {
      font-size: 14px;
      color: #333;
      margin-bottom: 5px;
      display: block;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 15px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .remember {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      margin-bottom: 15px;
    }

    button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-login {
      background-color: #007bff;
      color: white;
      margin-bottom: 10px;
    }

    .btn-login:hover {
      background-color: #0069d9;
    }

    .btn-google {
      background-color: white;
      border: 1px solid #ccc;
      color: #555;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-google img {
      width: 18px;
    }

    .divider {
      text-align: center;
      font-size: 13px;
      color: #999;
      margin: 10px 0;
    }

    .error {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <!-- CENTERED LOGIN -->
  <div class="center-wrap">
    <div class="login-box">
      <img src="/images/logopolines.png" class="logo" alt="Logo Polines">
      <h2>SITAMA</h2>

      @if(session('error'))
        <div class="error">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('login.post') }}"> 
        @csrf
        <div class="form-group">
          <label for="email">Alamat Email</label>
          <input type="email" name="email" id="email" placeholder="Alamat Email" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter Password" required>
        </div>

        <div class="remember">
          <div>
            <input type="checkbox" id="remember"> <label for="remember">Remember Me</label>
          </div>
          <a href="#" style="text-decoration:none;color:#007bff;">Lupa password?</a>
        </div>

        <button type="submit" class="btn-login">Masuk</button>

        <div class="divider">atau</div>

        <button type="button" class="btn-google">
          <img src="/images/logogoogle.png" alt="Google Logo">
          Masuk dengan Email Polines
        </button>

      </form>
    </div>
  </div>

</body>
</html>
