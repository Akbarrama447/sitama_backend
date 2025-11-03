<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SITAMA POLINES')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
         body {
            min-height: 100vh;
            background: linear-gradient(180deg, #ffffffff 0%, #ffffffff 50%, #5fa7ffff 100%);
            color: #000000ff;
            font-family: "Nunito Sans", sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.39);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            
        }
        .sidebar img {
            width: 70px;
            margin-bottom: 10px;
        }
        .sidebar h5 {
            font-weight: 600;
            margin-bottom: 30px;
        }
        .sidebar a {
        color: #000000ff;
        text-decoration: none;
        display: block;
        width: 100%;
        padding: 10px 20px;
        margin: 5px 0;
        border-radius: 8px;
        position: relative;
        transition: all 0.3s ease;
        }
        
        .sidebar a:hover {
    background: rgba(148, 221, 255, 0.62);
    transform: translateX(5px);
        }

        .sidebar a.active {
            color: #ffffff;
    background: linear-gradient(90deg, #007BFF, #00C6FF); /* 🌈 gradasi aktif */
    font-weight: 700;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    transform: translateX(8px);
}

        .main-content {
            margin-left: 270px;
            padding: 40px;
        }
        .card {
            background: #5fa7ffff;
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(8px);

            color: #ffffffff;
        }
        .card h2 {
            font-weight: 800;
        }
        .card h5 {
            font-weight: 500;
        }


    </style>
</head>
<body>

    <div class="sidebar">
        <img src="/images/logopolines.png" alt="Polines Logo" width="70">
        <h5>SITAMA DOSEN</h5>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('dosen.sidang') }}" class="{{ request()->routeIs('dosen.sidang') ? 'active' : '' }}">Sidang Tugas Akhir</a>
        <a href="{{ route('dosen.bimbingan') }}" class="{{ request()->routeIs('dosen.bimbingan') ? 'active' : '' }}">Mahasiswa Bimbingan</a>
        <a href="#">Penilaian</a>
        <a href="#">Pengaturan</a>
        <a href="/logout">🚪 Logout</a>
    </div>

   
    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>
