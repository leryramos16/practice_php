<?php 
include 'inc/header.php';
?>
   <div class="container feed-container">

    <!-- Post Composer -->
    <div class="card mb-4 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center mb-3">
          <img src="https://via.placeholder.com/45" class="profile-pic">
          <input type="text" class="form-control rounded-pill" placeholder="What's on your mind?">
        </div>

        <form action="/meal/upload" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="mealImage" class="form-label fw-bold">Upload your meal photo:</label>
            <input type="file" class="form-control" name="meal_image" id="mealImage" accept="image/*" required>
          </div>

          <!-- Preview box -->
          <div id="previewContainer" class="mb-3 text-center">
            
          </div>

          <div class="mb-3">
            <input type="text" class="form-control" name="caption" placeholder="Write a caption...">
          </div>

          <button type="submit" class="btn btn-primary w-100">Post</button>
        </form>
      </div>
    </div>


   

  </div>



   


<script>
document.getElementById('mealImage').addEventListener('change', function(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('mealPreview');

  if (file) {
    const reader = new FileReader();

    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };

    reader.readAsDataURL(file); // converts image file to base64 URL
  } else {
    preview.style.display = 'none';
  }
});

document.getElementById('mealImage').addEventListener('change', function(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('mealPreview');

  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  } else {
    preview.style.display = 'none';
  }
});
</script>

<?php 
include 'inc/footer.php';
?>



