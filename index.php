<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <link rel="icon" href="./favicon.ico">
    <link rel="manifest" href="./webmanifest.json">
    <title>URL Expander</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex flex-col justify-center items-center min-h-screen bg-gray-900">
<h1 class="text-center text-4xl text-gray-100 py-3">URL Expander</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"
      method="get" class="p-3 md:w-2/6">
    <div class="flex justify-center">
        <input type="text" name="link" id="link" class="flex-1 p-3 focus:outline-none"
               placeholder="Paste any short URL (https://bit.ly/3qb40Bs)"
               value="<?php if (isset($_GET['link'])) echo $_GET['link'] ?>">
        <button type="submit" class="ml-2 p-3 bg-gray-600 text-gray-100">Submit</button>
    </div>
    <?php

    if (isset($_GET['link'])) {
        $url = $_GET['link'];
        if (!empty($url)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $a = curl_exec($ch);
            $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

            echo '<div class="mt-2"><p class="text-center text-gray-100">Expanded URL</p><a href="' . $url . '" target="_blank"><p class="break-all mt-2 p-3 bg-gray-600 rounded text-white">' . $url . '</p></a></div>';
        }
    }

    ?>
</form>
</body>
</html>