<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <div class="app-container">
        <div class="app-image">
            <picture>
                <source srcset="/build/img/1.webp" type="image/webp" />
                <img loading="lazy" src="/build/img/1.jpg" alt="layout">
            </picture>
        </div>
        <?php echo $content; ?>
    </div>

    <?php echo $script ?? ''; ?>
</body>

</html>