<style>
.profile-wrap { max-width: 600px; margin: 0 auto; }
.profile-card {
    background: var(--white);
    border-radius: var(--radius);
    padding: 2.5rem;
    box-shadow: var(--shadow);
    border: 1.5px solid var(--border);
    text-align: center;
}
.profile-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--lilac);
    margin: 0 auto 1.2rem;
    display: block;
}
.profile-placeholder {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--lilac), var(--rose));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.8rem;
    margin: 0 auto 1.2rem;
    border: 4px solid var(--white);
    box-shadow: var(--shadow);
}
.profile-name {
    font-family: 'DM Serif Display', serif;
    font-size: 1.8rem;
    color: var(--ink);
    margin-bottom: .3rem;
}
.profile-email {
    font-size: .95rem;
    color: var(--muted);
    margin-bottom: 1.2rem;
}
.profile-badge {
    display: inline-block;
    background: var(--mint);
    color: #1d6b38;
    font-size: .78rem;
    font-weight: 600;
    padding: .25rem .8rem;
    border-radius: 50px;
    margin-bottom: 1.2rem;
}
.profile-bio {
    background: var(--cream);
    border-radius: 12px;
    padding: 1rem 1.2rem;
    font-size: .95rem;
    color: var(--ink);
    line-height: 1.7;
    text-align: left;
    margin-bottom: 1.5rem;
}
.profile-meta {
    font-size: .8rem;
    color: var(--muted);
    margin-bottom: 1.5rem;
    text-align: left;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .6rem;
}
.profile-meta span { background: var(--sand); padding: .45rem .75rem; border-radius: 8px; }
.profile-actions { display: flex; gap: .75rem; justify-content: center; }
</style>

<div class="profile-wrap">
    <div style="margin-bottom:1.5rem;">
        <a href="/users" style="color:var(--muted);text-decoration:none;font-size:.9rem;">← Back to Directory</a>
    </div>

    <div class="profile-card">
        <?php if ($user['avatar'] && file_exists(ROOTPATH . 'public/uploads/' . $user['avatar'])): ?>
            <img src="/uploads/<?= esc($user['avatar']) ?>" alt="<?= esc($user['name']) ?>" class="profile-avatar">
        <?php else: ?>
            <div class="profile-placeholder">
                <?= mb_strtoupper(mb_substr($user['name'], 0, 1)) ?>
            </div>
        <?php endif; ?>

        <div class="profile-name"><?= esc($user['name']) ?></div>
        <div class="profile-email">📧 <?= esc($user['email']) ?></div>
        <div class="profile-badge">✓ Member</div>

        <?php if ($user['bio']): ?>
            <div class="profile-bio"><?= nl2br(esc($user['bio'])) ?></div>
        <?php endif; ?>

        <div class="profile-meta">
            <span>🗓 Joined <?= date('M j, Y', strtotime($user['created_at'])) ?></span>
            <span>🆔 User #<?= $user['id'] ?></span>
        </div>

        <div class="profile-actions">
            <a href="/users" class="btn btn-secondary">← Directory</a>
            <form method="post" action="/users/delete/<?= $user['id'] ?>" onsubmit="return confirm('Delete this user permanently?')">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">🗑 Delete User</button>
            </form>
        </div>
    </div>
</div>
