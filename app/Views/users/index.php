<style>
/* ── Search bar ─────────────────────────────────────────── */
.search-bar {
    display: flex;
    gap: .75rem;
    margin-bottom: 1.8rem;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 50px;
    padding: .4rem .4rem .4rem 1.2rem;
    box-shadow: var(--shadow);
    align-items: center;
}
.search-bar input {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 1rem;
    padding: .3rem 0;
    outline: none;
}
.search-bar button {
    background: var(--lilac);
    border: none;
    border-radius: 50px;
    padding: .5rem 1.4rem;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: .9rem;
    cursor: pointer;
    color: var(--ink);
    transition: background .2s;
}
.search-bar button:hover { background: #c9b0ef; }

/* ── Header row ─────────────────────────────────────────── */
.dir-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.result-count {
    font-size: .88rem;
    color: var(--muted);
    font-style: italic;
}

/* ── User cards ─────────────────────────────────────────── */
.user-grid { display: flex; flex-direction: column; gap: 1rem; }

.user-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 1.4rem 1.6rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    box-shadow: var(--shadow);
    transition: transform .2s, box-shadow .2s;
}
.user-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

/* Pastel accent strip per card (cycling) */
.user-card:nth-child(5n+1) { border-left: 5px solid var(--rose); }
.user-card:nth-child(5n+2) { border-left: 5px solid var(--sky); }
.user-card:nth-child(5n+3) { border-left: 5px solid var(--mint); }
.user-card:nth-child(5n+4) { border-left: 5px solid var(--lemon); }
.user-card:nth-child(5n+5) { border-left: 5px solid var(--lilac); }

.avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid var(--border);
    flex-shrink: 0;
}
.avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--sand);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    flex-shrink: 0;
    border: 2.5px solid var(--border);
}
.user-info { flex: 1; min-width: 0; }
.user-name {
    font-family: 'DM Serif Display', serif;
    font-size: 1.15rem;
    color: var(--ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.user-email {
    font-size: .85rem;
    color: var(--muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.user-bio {
    font-size: .83rem;
    color: var(--muted);
    margin-top: .2rem;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.user-actions { display: flex; gap: .5rem; flex-shrink: 0; }

/* ── Pagination ─────────────────────────────────────────── */
.pager-wrap {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}
.pager-wrap nav { display: flex; gap: .4rem; align-items: center; }
.pager-wrap a,
.pager-wrap span {
    padding: .45rem .9rem;
    border-radius: 50px;
    font-size: .88rem;
    font-weight: 500;
    text-decoration: none;
    transition: all .15s;
}
.pager-wrap a { background: var(--white); color: var(--ink); border: 1.5px solid var(--border); }
.pager-wrap a:hover { background: var(--lilac); border-color: var(--lilac); }
.pager-wrap span { background: var(--lilac); color: var(--ink); border: 1.5px solid var(--lilac); }

/* ── Empty state ─────────────────────────────────────────── */
.empty {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--muted);
}
.empty-emoji { font-size: 3rem; margin-bottom: 1rem; }
.empty h3 { font-family: 'DM Serif Display', serif; font-size: 1.4rem; margin-bottom: .4rem; color: var(--ink); }
</style>

<div class="dir-header">
    <h1 class="page-title">
        User Directory
        <small>Showing <?= count($users) ?> of <?= $pager->getTotal() ?? 0 ?> users</small>
    </h1>
    <a href="/users/create" class="btn btn-primary">+ Add User</a>
</div>

<!-- Search -->
<form method="get" action="/users">
    <div class="search-bar">
        <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Search by name or email…">
        <button type="submit">Search</button>
        <?php if ($search): ?>
            <a href="/users" style="padding:.4rem .8rem;color:var(--muted);text-decoration:none;font-size:.85rem;">✕ Clear</a>
        <?php endif; ?>
    </div>
</form>

<?php if (empty($users)): ?>
    <div class="empty">
        <div class="empty-emoji">🌸</div>
        <h3>No users found</h3>
        <p><?= $search ? 'Try a different search term.' : 'Add your first user to get started!' ?></p>
    </div>
<?php else: ?>
    <div class="user-grid">
        <?php foreach ($users as $user): ?>
        <div class="user-card">
            <?php if ($user['avatar'] && file_exists(ROOTPATH . 'public/uploads/' . $user['avatar'])): ?>
                <img src="/uploads/<?= esc($user['avatar']) ?>" alt="<?= esc($user['name']) ?>" class="avatar">
            <?php else: ?>
                <div class="avatar-placeholder">
                    <?= mb_strtoupper(mb_substr($user['name'], 0, 1)) ?>
                </div>
            <?php endif; ?>

            <div class="user-info">
                <div class="user-name"><?= esc($user['name']) ?></div>
                <div class="user-email">📧 <?= esc($user['email']) ?></div>
                <?php if ($user['bio']): ?>
                    <div class="user-bio"><?= esc($user['bio']) ?></div>
                <?php endif; ?>
            </div>

            <div class="user-actions">
                <a href="/users/<?= $user['id'] ?>" class="btn btn-secondary btn-sm">View</a>
                <form method="post" action="/users/delete/<?= $user['id'] ?>" onsubmit="return confirm('Delete this user?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pager-wrap">
        <?= $pager->links('default', 'pastel_pager') ?>
    </div>
<?php endif; ?>
