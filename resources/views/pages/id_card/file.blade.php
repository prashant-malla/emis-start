@include('templates.id_cards.student.theme1')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.onafterprint = window.close;
        window.print();
    });
</script>