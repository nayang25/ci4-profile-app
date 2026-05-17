<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ProfilePal') ?> · ProfilePal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ── Pastel Design System ─────────────────────────────── */
        :root {
            --rose:    #f9c6ce;
            --peach:   #ffd8b1;
            --lemon:   #fef5b3;
            --mint:    #c5f0d3;
            --sky:     #b8e3f9;
            --lilac:   #dac8f5;
            --cream:   #fdf8f3;
            --sand:    #f2ece4;
            --ink:     #2d2a35;
            --muted:   #7a7585;
            --border:  #e8e1d9;
            --white:   #ffffff;
            --radius:  18px;
            --shadow:  0 4px 24px rgba(45,42,53,.08);
            --shadow-lg: 0 12px 48px rgba(45,42,53,.13);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--ink);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ── Nav ───────────────────────────────────────────────── */
        nav {
            background: var(--white);
            border-bottom: 1.5px solid var(--border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(45,42,53,.05);
        }

        .nav-brand {
            font-family: 'DM Serif Display', serif;
            font-size: 1.5rem;
            color: var(--ink);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .nav-brand span { font-size: 1.4rem; }

        .nav-links { display: flex; gap: .5rem; align-items: center; }
        .nav-links a {
            padding: .4rem 1rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            color: var(--muted);
            transition: background .2s, color .2s;
        }
        .nav-links a:hover { background: var(--sand); color: var(--ink); }
        .nav-links .btn-nav {
            background: var(--lilac);
            color: var(--ink);
            padding: .45rem 1.2rem;
        }
        .nav-links .btn-nav:hover { background: #c9b0ef; }

        /* ── Page wrapper ──────────────────────────────────────── */
        .page { max-width: 900px; margin: 0 auto; padding: 2.5rem 1.5rem 4rem; }

        /* ── Flash messages ────────────────────────────────────── */
        .flash {
            padding: .85rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            font-size: .95rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .flash-success { background: var(--mint); color: #1d6b38; }
        .flash-error   { background: var(--rose); color: #8b2230; }

        /* ── Cards ─────────────────────────────────────────────── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1.5px solid var(--border);
        }

        /* ── Buttons ───────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .55rem 1.4rem;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-primary   { background: var(--lilac); color: var(--ink); }
        .btn-primary:hover { background: #c9b0ef; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(174,144,240,.35); }
        .btn-danger    { background: var(--rose); color: #8b2230; }
        .btn-danger:hover { background: #f5a8b4; }
        .btn-secondary { background: var(--sand); color: var(--muted); }
        .btn-secondary:hover { background: var(--border); }
        .btn-sm { padding: .35rem .9rem; font-size: .82rem; }

        /* ── Forms ─────────────────────────────────────────────── */
        .form-group { margin-bottom: 1.4rem; }
        label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        input[type="text"],
        input[type="email"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: .7rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            color: var(--ink);
            background: var(--cream);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        input:focus, textarea:focus {
            border-color: #c5a8f0;
            box-shadow: 0 0 0 3px rgba(197,168,240,.2);
            background: var(--white);
        }
        textarea { min-height: 100px; resize: vertical; }
        .field-error { color: #c0392b; font-size: .82rem; margin-top: .3rem; }

        /* ── Page title ────────────────────────────────────────── */
        .page-title {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: var(--ink);
            margin-bottom: 1.5rem;
        }
        .page-title small {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            font-weight: 400;
            color: var(--muted);
            margin-top: .2rem;
        }
    </style>
</head>
<body>

<nav>
    <a href="/users" class="nav-brand"><span>🌸</span> ProfilePal</a>
    <div class="nav-links">
        <a href="/users">Directory</a>
        <a href="/users/create" class="btn-nav">+ Add User</a>
    </div>
</nav>

<div class="page">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash flash-success">✅ <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash flash-error">⚠️ <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?= $content ?>

</div>

</body>
</html>
