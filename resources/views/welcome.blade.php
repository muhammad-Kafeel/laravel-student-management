<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Student Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .welcome-card {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
            transition: transform 0.3s ease;
        }

        .welcome-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: #04AA6D;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            color: #2d3436;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }

        p {
            color: #636e72;
            margin-bottom: 2rem;
        }

        .btn-dashboard {
            background-color: #04AA6D;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(4, 170, 109, 0.3);
        }

        .btn-dashboard:hover {
            background-color: #038d5a;
            color: white;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(4, 170, 109, 0.4);
        }
    </style>
</head>
<body>

    <div class="welcome-card">
        <div class="icon-box">
            🎓
        </div>
        <h1>Student Management</h1>
        <p>Streamline your administrative tasks, manage student records, and track payments efficiently in one place.</p>
        
        <a href="{{ url('/dashboard') }}" class="btn-dashboard">
            Go to Dashboard
        </a>
        
        <div class="mt-4">
            <small class="text-muted">Logged in as Administrator</small>
        </div>
    </div>

</body>
</html>
