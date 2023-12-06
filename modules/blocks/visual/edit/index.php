<? //modules/blocks/visual/edit
// Use object $blockProperty
?>
<script src="/<?= DIR_MODULES ?>/blocks/visual/edit/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea.editortextarea'
    });
</script>
<div>
    <textarea class="editortextarea" name="block_<?= $blockProperty["id"] ?>"><?= $blockProperty["content"] ?></textarea>
</div>