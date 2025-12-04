<?php
$title = "My Fit App";
include 'inc/header.php';
?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">

  <div class="text-center" style="width: 300px;"> 
      <h2 class="mb-4">Add Contact</h2>

      <form method="POST" action="<?= ROOT ?>/phonebook/add">
          <div class="mb-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
              <label>Phonenumber</label>
              <input type="text"
                name="phone"
                pattern="09[0-9]{9}"
                maxlength="11"
                class="form-control"
                required>

          </div>

          <button type="submit" class="btn btn-success w-100">Save Contact</button>
      </form>
  </div>

</div>
<?php 
include 'inc/footer.php';
?>