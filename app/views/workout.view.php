<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/track/0U87auHx1iZTEFcq9KVdmO?utm_source=generator" width="100%" height="200" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/track/6L89mwZXSOwYl76YXfX13s?utm_source=generator" width="100%" height="200" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/track/4wzjNqjKAKDU82e8uMhzmr?utm_source=generator" width="100%" height="200" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/track/2Guz1b911CbpG8L92cnglI?utm_source=generator" width="100%" height="200" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>


<?php 
// PHP part runs first (on the server)
$alarmTime = "20:46";
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <h2>My Alarm Project</h2>
  <p>Alarm set at: <?= $alarmTime ?></p>

  <script>
    // JavaScript runs after the page loads (in browser)
    const alarmTime = "<?= $alarmTime ?>"; // PHP passes value to JS

    function checkAlarm() {
      const now = new Date();
      const [h, m] = alarmTime.split(":");
      if (now.getHours() == h && now.getMinutes() == m) {
        alert("⏰ Alarm ringing!");
        const audio = new Audio("https://actions.google.com/sounds/v1/alarms/alarm_clock.ogg");
        audio.play();
      }
    }

    setInterval(checkAlarm, 1000); // check every second
  </script>
</body>
</html>

