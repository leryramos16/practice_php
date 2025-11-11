<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'My App'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a href="<?= ROOT ?>/dashboard" class="navbar-brand" href="#">My Fitness Journey</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/dashboard">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/planner">Day Plan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/workout">Favorite Musics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/friends">Friends</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/phonebook">Phonebook</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
           <h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['username']); ?></h6> 
          <a class="dropdown-item" href="<?= ROOT ?>/profile">Profile Settings</a>
          <a class="dropdown-item" href="<?= ROOT ?>/friends/list">Friends Lists</a>
          <a class="dropdown-item" href="<?= ROOT ?>/friends/requests">Friends Requests</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= ROOT ?>/logout">Logout</a>
        </div>
      </li>
    </ul>
    <form action="<?= ROOT ?>/friends/search" method="POST" class="form-inline my-2 my-lg-0">
  <input 
    class="form-control mr-sm-2" 
    type="search" 
    name="search" 
    placeholder="Search users..." 
    aria-label="Search"
   
  >
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>

  </div>
</nav>


