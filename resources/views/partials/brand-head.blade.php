{{--
    Cornerstone Investment Group — shared brand head.
    Single source of truth for the public-facing design system.
    Loaded via CDN only (Bootstrap 5 + Google Fonts) so it works on cPanel with no build step.

    Palette (Branding Guide):
      Dark Blue Accent .... #0D4EA3   primary actions, headings
      Core Logo Blue ...... #5AA4ED   secondary, links, highlights
      Primary Light Blue .. #B8D8F8   soft fills, borders, tints
      Invoice Slate Blue .. #2F5870   dark sections, footer
      Security Cream ...... #FFF8EC   warm section backgrounds

    Type: Cormorant Garamond (display headings) · Montserrat (UI/labels/buttons)
          Body uses a system stack (brand body font "Aptos" is not available on the web).
--}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('assets/images/cig-icon.png') }}">

<style>
    :root {
        --cig-dark: #0D4EA3;
        --cig-dark-2: #0a3d80;
        --cig-blue: #5AA4ED;
        --cig-light: #B8D8F8;
        --cig-slate: #2F5870;
        --cig-cream: #FFF8EC;
        --cig-ink: #1b2a3d;
        --cig-muted: #5d7188;
        --cig-line: #e6eef7;

        --font-display: 'Cormorant Garamond', Georgia, 'Times New Roman', serif;
        --font-ui: 'Montserrat', Arial, sans-serif;
        --font-body: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    body {
        font-family: var(--font-body);
        color: var(--cig-ink);
        background-color: #ffffff;
        overflow-x: hidden;
    }

    /* ---- Typography ---- */
    h1, h2, h3, h4, h5, .font-display {
        font-family: var(--font-display);
        font-weight: 600;
        color: var(--cig-slate);
        letter-spacing: .2px;
    }
    .font-ui { font-family: var(--font-ui); }

    .eyebrow {
        font-family: var(--font-ui);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        font-size: .72rem;
        color: var(--cig-blue);
    }

    .text-cig-dark   { color: var(--cig-dark) !important; }
    .text-cig-blue   { color: var(--cig-blue) !important; }
    .text-cig-slate  { color: var(--cig-slate) !important; }
    .text-cig-muted  { color: var(--cig-muted) !important; }

    .bg-cig-dark   { background-color: var(--cig-dark) !important; }
    .bg-cig-slate  { background-color: var(--cig-slate) !important; }
    .bg-cig-light  { background-color: var(--cig-light) !important; }
    .bg-cig-cream  { background-color: var(--cig-cream) !important; }
    .bg-cig-soft   { background-color: #f3f8fe !important; }

    /* ---- Buttons ---- */
    .btn-cig {
        font-family: var(--font-ui);
        font-weight: 600;
        letter-spacing: .3px;
        background: linear-gradient(135deg, var(--cig-dark) 0%, var(--cig-dark-2) 100%);
        border: none;
        color: #fff;
        padding: 12px 30px;
        border-radius: 8px;
        box-shadow: 0 6px 18px rgba(13, 78, 163, 0.22);
        transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
    }
    .btn-cig:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 26px rgba(13, 78, 163, 0.32);
    }
    .btn-cig-light {
        font-family: var(--font-ui);
        font-weight: 600;
        background: #fff;
        color: var(--cig-dark);
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        transition: all .2s ease;
    }
    .btn-cig-light:hover { color: var(--cig-dark-2); transform: translateY(-2px); }

    .btn-cig-outline {
        font-family: var(--font-ui);
        font-weight: 600;
        background: transparent;
        color: var(--cig-dark);
        border: 2px solid var(--cig-light);
        padding: 10px 26px;
        border-radius: 8px;
        transition: all .2s ease;
    }
    .btn-cig-outline:hover {
        border-color: var(--cig-dark);
        color: var(--cig-dark);
        background: #f3f8fe;
    }

    /* ---- Badges / pills ---- */
    .badge-cig {
        font-family: var(--font-ui);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: .68rem;
        color: var(--cig-dark);
        background: var(--cig-light);
        padding: 7px 16px;
        border-radius: 50px;
        display: inline-block;
    }
    .badge-cig-dark {
        background: var(--cig-dark);
        color: #fff;
    }

    /* ---- Navbar ---- */
    .cig-navbar {
        background: #ffffff;
        box-shadow: 0 2px 18px rgba(20, 50, 90, 0.06);
        padding: 10px 0;
    }
    .cig-navbar .navbar-brand img { height: 52px; width: auto; }
    .cig-navbar .nav-link {
        font-family: var(--font-ui);
        font-weight: 500;
        color: var(--cig-slate) !important;
        margin: 0 6px;
        transition: color .2s ease;
    }
    .cig-navbar .nav-link:hover,
    .cig-navbar .nav-link.active { color: var(--cig-dark) !important; }

    /* ---- Cards ---- */
    .cig-card {
        background: #fff;
        border: 1px solid var(--cig-line);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(20, 50, 90, 0.05);
    }

    /* ---- Footer ---- */
    .cig-footer {
        background: var(--cig-slate);
        color: rgba(255, 255, 255, 0.78);
        font-size: .95rem;
    }
    .cig-footer h6 {
        font-family: var(--font-ui);
        color: #fff;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: .8rem;
        margin-bottom: 18px;
    }
    .cig-footer a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        display: block;
        margin-bottom: 10px;
        transition: color .2s ease;
    }
    .cig-footer a:hover { color: var(--cig-light); }
    .cig-footer .footer-icon {
        background: #fff;
        border-radius: 10px;
        padding: 8px 10px;
        display: inline-flex;
    }
    .cig-footer .footer-icon img { height: 38px; width: auto; }

    /* ---- Section rhythm ---- */
    .section { padding: 84px 0; }
    .section-tight { padding: 56px 0; }
</style>
