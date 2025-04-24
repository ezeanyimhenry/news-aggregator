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
        /* Light grey background for contrast */
        margin: 0;
        font-family: sans-serif;
    }

    .card {
        width: 1080px;
        height: 1080px;
        background-color: #8F0404;
        /* FF at the end for opacity is default */
        display: flex;
        flex-direction: column;
        /* Stack inner container and logo vertically */
        justify-content: space-between;
        /* Distribute space between items */
        align-items: center;
        /* Center items horizontally */
        padding: 40px;
        /* Add some padding */
        box-sizing: border-box;
        /* Include padding in width/height */
        border-radius: 15px;
        /* Optional: rounded corners */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        /* Optional: subtle shadow */
    }

    .inner-container {
        background-color: white;
        width: 90%;
        /* Relative width */
        height: 75%;
        /* Increased height */
        padding: 30px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center title and image */
        box-sizing: border-box;
    }

    .inner-container h1 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    /*
.inner-container img {
    max-width: 100%;
    height: auto;
    display: block;
    border-radius: 5px;
}
*/

    .inner-container .image-placeholder {
        width: 100%;
        /* Take full width of the inner container */
        height: 400px;
        /* Set a fixed height for the placeholder */
        background-image: url('{!! $imageUrl !!}');
        background-size: cover;
        /* Make the image cover the container */
        background-position: center;
        /* Center the image */
        background-repeat: no-repeat;
        border-radius: 5px;
        /* Optional: match rounding */
    }

    .logo {
        /* Adjust logo container styles */
        color: white;
        /* Keep for fallback or potential text */
        text-align: center;
        /* Remove border/padding specific to text logo if needed */
        border: none;
        padding: 0;
        /* Add max-width or height if needed */
        width: 200px;
        /* Example width */
    }

    .logo img {
        /* Style the logo image */
        max-width: 100%;
        /* Ensure logo fits within its container */
        height: auto;
        /* Maintain aspect ratio */
        display: block;
        /* Remove extra space below image */
        margin: 0 auto;
        /* Center the image if container is wider */
    }
</style>

<body>
    <div class="card">
        <div class="inner-container">
            <h1>{{ $title ?? '' }}</h1>
            <!-- Replace the img tag with a div for background image -->
            <div class="image-placeholder"></div>
        </div>
        <div class="logo">
            <!-- Replace the span with an img tag for the logo -->
            <img src="{{ $siteLogo }}" alt="{{ $siteName }}" alt="Logo">
        </div>
    </div>
</body>

</html>
