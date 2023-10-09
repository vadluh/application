<?php
try {
    require('../Service/ApiConnector.php');
    require('../Model/UserList.php');

    $connector = new ApiConnector();
//    $apiData = $connector->receive();
//    $apiData = $connector->receiveByCurl();
    $apiData = $connector->emulateReceive(rtrim(getcwd(), 'pub') . 'fixtures/data.json');

    $userListModel = new UserList();
    $users = $userListModel->prepareData($apiData);
} catch (\Exception $e) {
    $error = $e->getMessage();
    $users = [];
}
?>

<html>
    <head>
        <title>List of customers</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif;?>
        <?php if (empty($users)): ?>
            <?php include ('../View/general/empty.php') ?>
        <?php else: ?>
            <?php include ('../View/customer/list.php') ?>
            <?php include ('../View/general/list-actions.php') ?>
        <?php endif; ?>
    </body>
</html>