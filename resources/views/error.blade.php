<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
    <style>
        body {
            font-family: Arial;
            background: #111;
            color: white;
            text-align: center;
            padding-top: 100px;
        }
        .box {
            background: #222;
            padding: 30px;
            display: inline-block;
            border-radius: 10px;
        }
        h1 {
            color: red;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>⚠️ {{ $message ?? 'Unknown error occurred' }}</h1>

   

    <a href="/dashboard" style="color: cyan;">Go Back</a>
</div>

</body>
</html>