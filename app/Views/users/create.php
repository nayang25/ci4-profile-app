<style>
.form-card { max-width: 580px; margin: 0 auto; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
.avatar-preview {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border);
    margin-top: .8rem;
    display: none;
}
.avatar-zone {
    border: 2px dashed var(--border);
    border-radius: 14px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    background: var(--cream);
}
.avatar-zone:hover { border-color: #c5a8f0; background: #f8f3ff; }
.avatar-zone input { display: none; }
.avatar-zone label { cursor: pointer; font-size: .9rem; color: var(--muted); display: block; }
.avatar-zone .upload-icon { font-size: 2.5rem; margin-bottom: .5rem; display: block; }
.form-actions { display: flex; gap: .75rem; margin-top: 1.8rem; }
</style>

<div class="form-card">
    <div style="margin-bottom:1.5rem;">
        <a href="/users" style="color:var(--muted);text-decoration:none;font-size:.9rem;">← Back to Directory</a>
    </div>

    <h1 class="page-title">Add New User <small>Fill in the profile details below</small></h1>

    <?php if (isset($validation)): ?>
        <div class="flash flash-error">⚠️ Please fix the errors below.</div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('avatarError')): ?>
        <div class="flash flash-error">⚠️ <?= session()->getFlashdata('avatarError') ?></div>
    <?php endif; ?>

    <div class="card">
        <form method="post" action="/users/store" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="Jane Doe" required>
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <p class="field-error"><?= $validation->getError('name') ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="jane@example.com" required>
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <p class="field-error"><?= $validation->getError('email') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="bio">Bio / About</label>
                <textarea id="bio" name="bio" placeholder="A short bio about this user…"><?= old('bio') ?></textarea>
            </div>

            <div class="form-group">
                <label>Profile Photo</label>
                <div class="avatar-zone" onclick="document.getElementById('avatar').click()">
                    <span class="upload-icon">🖼️</span>
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewImage(this)">
                    <label>Click to upload (JPG, PNG, GIF, WEBP · max 2 MB)</label>
                    <img id="preview" class="avatar-preview" src="" alt="Preview">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">🌸 Save User</button>
                <a href="/users" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
