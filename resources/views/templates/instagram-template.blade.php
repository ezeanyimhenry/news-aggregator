<html>

<head>
    <title>{{ $title ?? '' }}</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f0f0f0;
        margin: 0;
        font-family: sans-serif;
    }

    .card {
        width: 1080px;
        height: 1080px;
        background-color: #8F0404;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 40px;
        box-sizing: border-box;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .card h1 {
        color: #ffffff;
        text-align: center;
        font-size: 3.6rem;
        font-weight: 700;
        line-height: 1.3;
        margin: 0;
        padding: 20px;
        position: absolute;
        top: 40px;
        width: 90%;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        font-family: 'Helvetica Neue', 'Segoe UI', sans-serif;
    }

    .image-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-placeholder {
        width: 100%;
        height: 500px;
        background-image: url('{!! $imageUrl !!}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 15px;
        border: 8px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .logo {
        position: absolute;
        bottom: 40px;
        width: 200px;
    }

    .logo img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }
</style>

<body>
    <div class="card">
        <h1>{{ $title ?? '' }}</h1>
        <div class="image-container">
            <div class="image-placeholder" style="background-image: url('{!! $imageUrl !!}')"></div>
        </div>
        <div class="logo">
            <img src="{{ $siteLogo }}" alt="{{ $siteName }}">
        </div>
    </div>
</body>

</html>
