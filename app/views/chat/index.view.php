<div id="chat-box" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
    <?php foreach ($messages as $msg): ?>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($msg['sender_image']) ?>" 
             width="40" height="40" style="border-radius:50%; margin-right:10px;">
        <div>
            <strong>
                <?php if ($msg['sender_id'] == $user_id): ?>
                    You:
                <?php else: ?>
                    <?= htmlspecialchars($msg['sender_name']) ?>:
                <?php endif; ?>
            </strong>
            <?= htmlspecialchars($msg['message']) ?><br>
            <small class="text-muted"><?= htmlspecialchars($msg['created_at']) ?></small>
        </div>
    </div>
<?php endforeach; ?>

</div>

<form id="chat-form">
    <input type="hidden" id="receiver_id" value="<?= $other_user_id ?>">
    <input type="text" id="message" placeholder="Type a message..." required>
    <button type="submit">Send</button>
</form>

<script>
document.getElementById('chat-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const receiver_id = document.getElementById('receiver_id').value;
    const message = document.getElementById('message').value;

    const res = await fetch('<?= ROOT ?>/chat/send', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `receiver_id=${receiver_id}&message=${encodeURIComponent(message)}`
    });

    if (res.ok) {
        document.getElementById('message').value = '';
        location.reload(); // simple refresh to show new message
    }
});

//auto refresh
setInterval(async () => {
    const res = await fetch('<?= ROOT ?>/chat/fetch/<?= $other_user_id ?>');
    if (!res.ok) return;
    const messages = await res.json();

    const chatBox = document.getElementById('chat-box');
    chatBox.innerHTML = '';

    messages.forEach(msg => {
        const div = document.createElement('div');
        div.style.display = 'flex';
        div.style.alignItems = 'center';
        div.style.marginBottom = '10px';

        div.innerHTML = `
            <img src="<?= ROOT ?>/uploads/${msg.sender_image}" 
                 width="40" height="40" 
                 style="border-radius:50%; margin-right:10px;">
            <div>
                <strong>${msg.sender_id == <?= $user_id ?> ? 'You' : msg.sender_name}:</strong>
                ${msg.message}<br>
                <small class="text-muted">${msg.created_at}</small>
            </div>
        `;
        chatBox.appendChild(div);
    });

    //chatBox.scrollTop = chatBox.scrollHeight;
}, 3000);


</script>

