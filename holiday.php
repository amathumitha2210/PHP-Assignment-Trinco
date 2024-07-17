<?php

$url = 'https://data.gov.sg/api/action/datastore_search?resource_id=6228c3c5-03bd-4747-bb10-85140f87168b&limit=10';
$response = file_get_contents($url);
$data = json_decode($response, true);


if ($data && isset($data['result']['records'])) {
    $holidays = $data['result']['records'];

    
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Public Holidays</title>
        <link rel="stylesheet" href="./Styles/styles.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container holiday-list">
            <h2>Public Holidays</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Holiday Name</th>
                        <th>Day</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($holidays as $holiday): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($holiday['date']); ?></td>
                            <td><?php echo isset($holiday['holiday']) ? htmlspecialchars($holiday['holiday']) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($holiday['day']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
} else {
    echo "Failed to fetch holidays data.";
}
?>
