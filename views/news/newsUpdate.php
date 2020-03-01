<?php

$pageDir = "News";
$pageTitle = "News Update";

$news = $data->getNewsByID($data->id);

require_once 'views/template/header.php';

if (isset($_POST["updateButton"])) {
    $news->Title = $_POST["Title"];
    $news->CreateDate = $_POST["CreateDate"];
    $news->UpdateDate = $_POST["UpdateDate"];
    $news->Description = $_POST["Description"];
    // $newsUpdate->NewsID = $_POST["NewsID"];
    $data->update($news);
    if ($news->NewsID) {
        header("location: /RollinAdmin/News/Detail/$news->NewsID");
    }
}

if (isset($_POST["BackToList"])) {
    header("location: ../List");
}


?>

<div class="container-fluid">

    <form method="post" action="News/Update/<?= $news->NewsID ?>">

        <div class="form-group">

            <label for="Title" class="text">
                NewsID : <?= $news->NewsID ?>
            </label>

        </div>

        <div class="form-group">
            <label for="Title" class="text">
                Title :
            </label>
            <input type="text" class="form-control" name="Title" id="Title" value="<?= $news->Title ?>">
        </div>

        <div class="form-group">
            <label for="CreateDate" class="date">
                CreateDate :
            </label>
            <input type="date" class="form-control" name="CreateDate" id="CreateDate" value="<?= $news->CreateDate ?>">
        </div>

        <div class="form-group">
            <label for="UpdateDate" class="date">
                UpdateDate :
            </label>
            <input type="date" class="form-control" name="UpdateDate" id="UpdateDate" value="<?= $news->UpdateDate ?>">
        </div>

        <div class="form-group">
            <label for="Description" class="text">
                Description :
            </label>
            <textarea type="text" class="form-control" name="Description" id="Description" style="height:200px"><?= $news->Description ?></textarea>
        </div>

        <input name="action" type="hidden" value="id">
        <button type="submit" class="btn btn-success" name="updateButton" id="updateButton">修改資料</button>
        <button type="submit" class="btn btn-danger" name="BackToList">取消</button>

    </form>
</div>
<!-- /.container-fluid -->

<?php  

require_once 'views/template/footer.php';

?>