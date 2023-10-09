<table class="table">
    <thead class="thead-light">
        <tr>
            <?php foreach ($users[0] as $columnCode => $columnValue): ?>
                <th scope="col">
                    <a href="?order_by=<?= $columnCode ?>&order=asc">&uarr;</a>
                    <?= UserList::FIELDS[$columnCode] ?>
                    <a href="?order_by=<?= $columnCode ?>&order=desc">&darr;</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="/">☢</a>
                </th>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <?php foreach ($user as $value): ?>
                    <td>
                        <?= $value ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>