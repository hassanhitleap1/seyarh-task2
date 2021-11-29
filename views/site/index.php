<?php
$this->title = 'Index';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">title</th>
            <th scope="col">thumbnailLink</th>
            <th scope="col">modifiedDate</th>
            <th scope="col">FileSize</th>
            <th scope="col">ownerNames</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php foreach ($results as $key=>$result):?>
                <th ><?= ++$key?></th>
                <td><?= $result->title?></td>
                <td><?= $result->thumbnailLink?></td>
                <td><?= $result->modifiedDate?></td>
                <td><?= $result->FileSize?></td>
                <td><?= $result->ownerNames?></td>
            <?php endforeach;?>
        </tr>

        </tbody>
    </table>
</div>


