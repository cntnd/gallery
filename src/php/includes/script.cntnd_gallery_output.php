<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.1/Sortable.min.js"></script>
<script>
$(document).ready(function() {

    $('.cntnd_gallery-button').click(function () {
        var uuid = $(this).data('uuid');
        $('#'+uuid).submit();
    });

});
</script>
