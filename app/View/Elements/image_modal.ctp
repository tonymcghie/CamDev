<div id="image-modal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modal-image">
    <div class="caption"></div>
</div>

<script>
    // Get the imagesModal
    var imagesModal = document.getElementById('image-modal');

    // Get the image and insert it inside the imagesModal - use its "alt" text as a caption
    var expandableImages = $('*[img-url]');
    var modalImage = $('#modal-image');
    expandableImages.click(function(){
        imagesModal.style.display = "block";
        modalImage.attr('src', $(this).attr('img-url'));
    });

    // Get the <span> element that closes the imagesModal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the imagesModal
    span.onclick = function() {
        imagesModal.style.display = "none";
    }
</script>