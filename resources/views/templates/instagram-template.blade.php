<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Instagram Post Template</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 1080px;
            height: 1080px;
            overflow: hidden;
            font-family: 'Roboto', Arial, sans-serif;
        }

        .container {
            width: 1080px;
            height: 1080px;
            background-color: #8F0404FF;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* justify-content: center; */
        }

        .image-placeholder {
            width: 800px;
            height: 400px;
            margin-top: 20px;
            background-color: #8F0404FF;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }

        .title-placeholder {
            max-width: 900px;
            color: white;
            font-size: 50px;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
            padding: 0 40px;
            line-height: 1.2;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .logo {
            position: absolute;
            bottom: 30px;
            right: 30px;
            font-size: 24px;
            color: #ffffff;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title-placeholder" id="article-title">
            {{ $title ?? '' }}
        </div>
        <div class="image-placeholder">
            <img src="{{ isset($imageUrl) ? $imageUrl : '' }}" alt="Article Image" id="article-image">
        </div>
        <div class="logo">
            <img src="{{ $siteLogo }}" alt="{{ $siteName }}" style="width: 150px">
        </div>
    </div>
</body>

</html>
