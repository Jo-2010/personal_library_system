<?php if(empty($books)): ?>    
    <span class="messageWarningErrorNoBooks <?= $_SESSION['messageTableBooks']['type'] ?? '' ?>"><?= $_SESSION['messageTableBooks']['text'] ?? 'No books have been added to the library...' ?></span>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author(s)</th>
                <th>Year</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($books as $bookAttribute): ?>
                <tr>
                    <td><?= $bookAttribute[0] ?></td>
                    <td><?= $bookAttribute[1] ?></td>
                    <td><?= $bookAttribute[2] ?></td>
                    <td><?= $bookAttribute[3] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>