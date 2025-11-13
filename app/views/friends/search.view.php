



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
    <h2>Search Results</h2>

    <?php foreach ($results as $user): ?>
        <div class="d-flex align-items-center mb-3">
            <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($user['profile_image']) ?>"
                 width="40" height="40" style="border-radius:50%; margin-right:10px;">
            <strong><?= htmlspecialchars($user['username']) ?></strong>

            <div class="search-result ml-auto">
                <?php if ($user['friend_status'] === 'none'): ?>
                    <button class="btn btn-primary btn-sm add-friend-btn" 
                      data-user-id="<?= $user['id'] ?>">Add Friend</button>
                    <button class="btn btn-info btn-sm cancel-friend-btn d-none" 
                      data-user-id="<?= $user['id'] ?>">Cancel Request</button>

                <?php elseif ($user['friend_status'] === 'pending'): ?>
                    <button class="btn btn-primary btn-sm add-friend-btn d-none" 
                      data-user-id="<?= $user['id'] ?>">Add Friend</button>
                    <button class="btn btn-info btn-sm cancel-friend-btn" 
                      data-user-id="<?= $user['id'] ?>">Cancel Request</button>

                    

                <?php elseif ($user['friend_status'] === 'accepted'): ?>
                     <button class="btn btn-success btn-sm" data-user-id="<?=  $user['id'] ?>" disabled>Friends</button>
                     <button class="btn btn-primary btn-sm add-friend-btn d-none" 
                      data-user-id="<?= $user['id'] ?>">Add Friend</button>

                <?php elseif ($user['friend_status'] === 'declined'): ?>
                    <button class="btn btn-warning btn-sm add-friend-btn" 
                      data-user-id="<?= $user['id'] ?>">Add Friend</button>
                    <button class="btn btn-info btn-sm cancel-friend-btn d-none" 
                      data-user-id="<?= $user['id'] ?>">Cancel Request</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>





<script>
document.addEventListener('DOMContentLoaded', () => {
  const addBtns = document.querySelectorAll('.add-friend-btn');
  const cancelBtns = document.querySelectorAll('.cancel-friend-btn');

  addBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
      const userId = btn.dataset.userId;

      const res = await fetch(`<?= ROOT ?>/friends/add/${userId}`, {
        method: 'POST'
      });

      if (res.ok) {
        btn.classList.add('d-none');
        btn.nextElementSibling.classList.remove('d-none'); // show cancel button
      }
    });
  });

  cancelBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
      const userId = btn.dataset.userId;

      const res = await fetch(`<?= ROOT ?>/friends/cancel/${userId}`, {
        method: 'POST'
      });

      if (res.ok) {
        btn.classList.add('d-none');
        btn.previousElementSibling.classList.remove('d-none'); // show add button
      }
    });
  });
});
</script>


<!-- Sa accept script-->
 <script>
document.addEventListener('DOMContentLoaded', () => {
    const acceptBtns = document.querySelectorAll('.accept-btn');
   

    acceptBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;

            const res = await fetch(`<?= ROOT ?>/friends/accept/${id}`, {
                method: 'POST'
            });

            if (res.ok) {
                btn.classList.add('d-none'); // hide confirm
                btn.nextElementSibling.classList.remove('d-none'); // show Friends
            }
        });
    });

    declineBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;

            const res = await fetch(`<?= ROOT ?>/friends/decline/${id}`, {
                method: 'POST'
            });

            if (res.ok) {
                const requestDiv = btn.closest('.search-result');
                requestDiv.remove();
            }
        });
    });
});
</script>


</body>
</html>
