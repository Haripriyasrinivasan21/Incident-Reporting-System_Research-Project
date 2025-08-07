<?php
include 'home_header.php';
?>

<style>
    .video-container {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }
    .video-container video {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 20px;
    }
    .overlay h1 {
        font-size: 3rem;
        font-weight: bold;
        text-shadow: 4px 4px 10px rgb(65, 3, 3); /* Red shadow effect */
    }
</style>

<div class="video-container">
    <video autoplay muted loop>
        <source src="uploads/backg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="overlay">
        <h1>Welcome to Incident Reporting System</h1>
    </div>
</div>

<?php
include 'home_footer.php';
?>
