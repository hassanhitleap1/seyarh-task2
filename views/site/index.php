<?php
use app\components\FileHelper;
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
            <th scope="col">EmbedLink</th>
            
            <th scope="col">modifiedDate</th>
            <th scope="col">webContentLink</th>
            
            <th scope="col">FileSize</th>
            <th scope="col">ownerNames</th>
        </tr>
        </thead>
        <tbody>
        
            <?php foreach ($results as $key=>$result):?>
                <tr>
                    <th ><?= ++$key?></th>
                    <td><?= $result['name']?></td>
                    <td><img  style="with:200px;height: 200px;" src="<?= $result['webContentLink'] ?>" /></td>
                    <td> <a href="<?= $result['webContentLink'] ?>" download> download</a></td>
                
                    <td><?= date('Y-m-d',strtotime($result['createdTime']))?></td>
                    <th scope="col"><?= $result['webContentLink']?></th>
                    
                    <td><?= FileHelper::formatSizeUnits($result['size']) ?></td>
                    <td>
                        <ul>
                        <?php foreach ($result['owners'] as $owner):?>
                            <li><?= $owner['displayName']?> </li>
                        <?php endforeach;?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach;?>
        

        </tbody>
    </table>
</div>


