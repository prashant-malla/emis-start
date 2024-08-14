@include('templates.certificates.character')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.onafterprint = window.close;
        window.print();
    });
</script>