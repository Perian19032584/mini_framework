<div class="container">




    <? new \vendor\widgets\menu\Menu(); ?>

    <button class="btn btn-default" id="send">Кнопка</button>
    <div id="anser"></div>

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="panel panel-default">
                <div class="panel-heading"><?= $post['title'] ?></div>
                <div class="panel-body">
                    <?= $post['text'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script src="../js/test.js"></script>
<script>
    $('#send').on('click', function (){
        $.ajax({
            url: "/main/test",
            type: "POST",
            data: {'id': 2},
            success: (res) => {
                $("#anser").html(res);
            },
            error: () => {
                alert('Произошла ошибка');
            }
        })
    });
</script>