<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'My App'; ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</head>
<style>
  .my-sticky {
    position: sticky;
    top: 0;
    z-index: 1000;
}

</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top my-sticky">
  <a href="<?= ROOT ?>/dashboard" class="navbar-brand" href="#">My Fitness Journey</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/dashboard">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/planner">Day Plan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/phonebook">Phonebook</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/physique/upload">Share Physique</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/guestmeal">Guest Meal</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/physique/feed">Friends</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="actionDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
           <span id="account-friend-notif" class="badge badge-secondary bg-danger ms-2" style="display:none;">0</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
           <h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['username']); ?></h6> 
          <a class="dropdown-item" href="<?= ROOT ?>/profile">Profile</a>
          <a class="dropdown-item" href="<?= ROOT ?>/friends/list">Chat Friends
             <span id="chat-message-badge" class="badge badge-danger" style="display:none;">0</span>
          </a>
          <a class="dropdown-item" href="<?= ROOT ?>/friends/requests">
            Friends Requests
            <span id="action-friend-notif" class="badge badge-secondary bg-danger" style="display:none;">0</span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= ROOT ?>/logout">Logout</a>
        </div>
      </li>
    </ul>
    <form action="<?= ROOT ?>/friends/search" method="POST" class="d-flex ms-auto">
      <input 
        class="form-control me-2" 
        type="search" 
        name="search" 
        placeholder="Search users..." 
        aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>


  </div>
</nav>




<!-- PARA BADGE SA FRIEND MESSAGE -->
<script>
async function updateFriendMessage() {
    try {
        const res = await fetch('<?= ROOT ?>/friends/notifications');
        const data = await res.json();

        const notif = document.getElementById('friend-message');
        if (notif) {
            notif.textContent = data.count;
            notif.style.display = data.count > 0 ? 'inline-block' : 'none';
        }
    } catch (err) {
        console.error('Notification error:', err);
    }
}

// Initial load
updateFriendMessage();

// Optional: poll every 30 seconds
setInterval(updateFriendMessage, 30000);
</script>


<script>
async function updateActionFriendNotifications() {
    try {
        const res = await fetch('<?= ROOT ?>/friends/notifications');
        const data = await res.json();

        const notif = document.getElementById('action-friend-notif');
        if (notif) {
            notif.textContent = data.count;
            notif.style.display = data.count > 0 ? 'inline-block' : 'none';
        }
    } catch (err) {
        console.error('Notification error:', err);
    }
}

// Initial load
updateActionFriendNotifications();

// Optional: poll every 30 seconds
setInterval(updateActionFriendNotifications, 30000);


//CHAT NOTIFICATION

async function updateChatMessageBadge() {
  try {
    const res = await fetch('<?= ROOT ?>/chat/notifications');
    const data = await res.json();

    const badge = document.getElementById('chat-message-badge');
    if(badge) {
      badge.textContent = data.count;
      badge.style.display = data.count > 0 ? 'inline-block' : 'none';
    }
  } catch (err) {
    console.error("Chat notification error:", err);
  }
}

// update once
updateChatMessageBadge();

// update every 20 seconds
setInterval(updateChatMessageBadge, 20000);

//DROPDOWN BADGE

async function updateAccountDropdownBadge() {
    try {
        // Fetch friend request count
        const resFriend = await fetch('<?= ROOT ?>/friends/notifications');
        const dataFriend = await resFriend.json();
        const friendCount = dataFriend.count || 0;

        // Fetch unread chat messages count
        const resChat = await fetch('<?= ROOT ?>/chat/notifications');
        const dataChat = await resChat.json();
        const chatCount = dataChat.count || 0;

        // Total notifications
        const totalCount = friendCount + chatCount;

        // Update main account badge
        const badge = document.getElementById('account-friend-notif');
        if (badge) {
            badge.textContent = totalCount;
            badge.style.display = totalCount > 0 ? 'inline-block' : 'none';
        }

        // Optional: update individual badges as well
        const chatBadge = document.getElementById('chat-message-badge');
        if (chatBadge) {
            chatBadge.textContent = chatCount;
            chatBadge.style.display = chatCount > 0 ? 'inline-block' : 'none';
        }

        const friendBadge = document.getElementById('action-friend-notif');
        if (friendBadge) {
            friendBadge.textContent = friendCount;
            friendBadge.style.display = friendCount > 0 ? 'inline-block' : 'none';
        }

    } catch (err) {
        console.error('Notification error:', err);
    }
}

// Initial load
updateAccountDropdownBadge();

// Poll every 20-30 seconds
setInterval(updateAccountDropdownBadge, 20000);



// NOTIFICATION 

async function updateLikeNotificationBadge() {
  try {
    const res = await fetch('<?= ROOT ?>/physique/notifs');
    const data = await res.json();

    const badge = document.getElementById('notification-badge');
    if (badge) {
      badge.textContent = data.count;
      badge.style.display = data.count > 0 ? 'inline-block' : 'none';
    }
  } catch (err) {
    console.error("Like notification error:", err);
  }
}

// Initial load
updateLikeNotificationBadge();

// Refresh every 20 seconds
setInterval(updateLikeNotificationBadge, 20000);


</script>










