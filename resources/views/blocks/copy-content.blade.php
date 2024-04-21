<script>
    function copyContent(id) {
        var content = document.getElementById('note-content-' + id).innerText;
        navigator.clipboard.writeText(content);
    }
</script>
