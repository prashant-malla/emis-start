<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<style>
  .edit-file-list .custom-upload{
    display: none;
  }

  .edit-file-list .dropify-wrapper{
    cursor: default;
  }
</style>

<script>
  const fileDeleteUrl = @json(@$fileDeleteUrl);

  function handleFileDelete(element, deleteUrl){
    $.ajax({
        url: deleteUrl,
        type: 'DELETE',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          file: element.file.name
        }
      }).done(function () {
        location.reload()
      }).fail(function() {
        alert( "Failed to delete File!" );
      });
  }

  function initFileUpload(input, deleteUrl = ''){
    const drInput = $(input).dropify();

    if(deleteUrl){
      drInput.on('dropify.beforeClear', function(event, element){
        const isUploadedFile = $(element.element).closest('.edit-file-list').length > 0;

        if(isUploadedFile){
          if(!confirmDelete()) return false;

          handleFileDelete(element, deleteUrl);
        }
      });
    }  
  }

  $(function(){
    initFileUpload('.custom-upload', fileDeleteUrl);
  });
</script>