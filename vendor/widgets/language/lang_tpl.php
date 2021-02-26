<select name="lang" id="lang">
    <option value="<?= $this->language['code']?>"><?= $this->language['title']?></option>
    <? foreach($this->languages as $code => $language): ?>
        <? if($this->language['code'] != $code) :?>
            <option value="<?= $code?>"><?= $language['title']?></option>
        <? endif?>
    <? endforeach;?>
</select>




<script>

    $("#lang").change(() => {
        window.location = "/language/change?lang=" + $("#lang").val();
    })
</script>