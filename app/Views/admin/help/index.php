<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @email      info@ramrastech.com
 * @mobile     +91-7317377477
 * @website    https://ramrastech.com
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .help-section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--accent);
        margin-bottom: 0.75rem;
    }
    .help-card {
        border-radius: 12px;
        transition: border-color 0.15s;
    }
    .help-card:hover {
        border-color: var(--accent) !important;
    }
    .help-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .accordion-button {
        background: var(--card-bg);
        color: var(--text-primary);
        font-size: 0.9rem;
        font-weight: 500;
        box-shadow: none !important;
    }
    .accordion-button:not(.collapsed) {
        background: rgba(99,102,241,0.08);
        color: var(--accent);
    }
    .accordion-button::after {
        filter: invert(1) opacity(0.5);
    }
    html[data-admin-theme="light"] .accordion-button::after {
        filter: none;
    }
    .accordion-item {
        background: var(--card-bg);
        border-color: var(--card-border) !important;
        color: var(--text-primary);
    }
    .accordion-body {
        font-size: 0.875rem;
        color: var(--text-muted);
        line-height: 1.7;
    }
    .step-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--accent);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .contact-card {
        border-radius: 12px;
        border: 1px solid var(--card-border);
        padding: 1.25rem 1.5rem;
        background: var(--card-bg);
        transition: border-color 0.15s;
    }
    .contact-card:hover {
        border-color: var(--accent);
    }
    .toc-link {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.85rem;
        display: block;
        padding: 0.3rem 0;
        border-left: 2px solid transparent;
        padding-left: 0.75rem;
        transition: all 0.15s;
    }
    .toc-link:hover {
        color: var(--accent);
        border-left-color: var(--accent);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <h2 class="fw-700 mb-1" style="font-size:1.4rem;">Help & Support</h2>
        <p class="mb-0" style="color:var(--text-muted); font-size:0.875rem;">Everything you need to manage your Product Gallery admin panel</p>
    </div>
    <a href="mailto:info@ramrastech.com" class="btn btn-primary btn-sm">
        <i class="bi bi-headset me-1"></i> Contact Support
    </a>
</div>

<div class="row g-4">

    <!-- Left Column -->
    <div class="col-lg-8">

        <!-- Quick Navigation Cards -->
        <div class="mb-4">
            <div class="help-section-title">Quick Navigation</div>
            <div class="row g-3">
                <div class="col-sm-6 col-md-4">
                    <a href="#getting-started" class="card help-card p-3 text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="help-icon-box" style="background:rgba(99,102,241,0.15); color:#6366f1;">
                                <i class="bi bi-rocket-takeoff"></i>
                            </div>
                            <div>
                                <div style="font-size:0.875rem; font-weight:600; color:var(--text-primary);">Getting Started</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">Overview & login</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4">
                    <a href="#products" class="card help-card p-3 text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="help-icon-box" style="background:rgba(16,185,129,0.15); color:#10b981;">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <div style="font-size:0.875rem; font-weight:600; color:var(--text-primary);">Products</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">Add, edit, manage</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4">
                    <a href="#enquiries" class="card help-card p-3 text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="help-icon-box" style="background:rgba(245,158,11,0.15); color:#f59e0b;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <div style="font-size:0.875rem; font-weight:600; color:var(--text-primary);">Enquiries</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">CRM & follow-ups</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4">
                    <a href="#content" class="card help-card p-3 text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="help-icon-box" style="background:rgba(239,68,68,0.15); color:#ef4444;">
                                <i class="bi bi-layout-text-window"></i>
                            </div>
                            <div>
                                <div style="font-size:0.875rem; font-weight:600; color:var(--text-primary);">Content</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">Pages & sections</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4">
                    <a href="#seo-media" class="card help-card p-3 text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="help-icon-box" style="background:rgba(20,184,166,0.15); color:#14b8a6;">
                                <i class="bi bi-search"></i>
                            </div>
                            <div>
                                <div style="font-size:0.875rem; font-weight:600; color:var(--text-primary);">SEO & Media</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">Meta & uploads</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4">
                    <a href="#faq-admin" class="card help-card p-3 text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="help-icon-box" style="background:rgba(168,85,247,0.15); color:#a855f7;">
                                <i class="bi bi-patch-question"></i>
                            </div>
                            <div>
                                <div style="font-size:0.875rem; font-weight:600; color:var(--text-primary);">FAQ</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">Common questions</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Getting Started -->
        <div class="card mb-4" id="getting-started">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-rocket-takeoff" style="color:var(--accent);"></i>
                <h6 class="mb-0 fw-600">Getting Started</h6>
            </div>
            <div class="card-body px-4 py-3">
                <p style="font-size:0.875rem; color:var(--text-muted);">Welcome to the Product Gallery Admin Panel. Here's a quick overview of how to get started.</p>

                <div class="mb-3">
                    <div class="help-section-title">Login & Authentication</div>
                    <div class="d-flex gap-2 mb-2">
                        <span class="step-badge">1</span>
                        <span style="font-size:0.875rem;">Navigate to <code>/admin/login</code> and enter your username/email and password.</span>
                    </div>
                    <div class="d-flex gap-2 mb-2">
                        <span class="step-badge">2</span>
                        <span style="font-size:0.875rem;">If 2FA is enabled, enter the OTP sent to your registered email.</span>
                    </div>
                    <div class="d-flex gap-2 mb-2">
                        <span class="step-badge">3</span>
                        <span style="font-size:0.875rem;">Use <strong>Forgot Password</strong> on the login page to reset via email if needed.</span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="help-section-title">Admin Roles</div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0" style="font-size:0.85rem;">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Access Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge" style="background:rgba(99,102,241,0.2); color:#a5b4fc;">Super Admin</span></td>
                                    <td>Full access including Settings & Themes</td>
                                </tr>
                                <tr>
                                    <td><span class="badge" style="background:rgba(16,185,129,0.2); color:#6ee7b7;">Manager</span></td>
                                    <td>Products, Categories, Enquiries, Content, SEO, Media</td>
                                </tr>
                                <tr>
                                    <td><span class="badge" style="background:rgba(245,158,11,0.2); color:#fcd34d;">Viewer</span></td>
                                    <td>Read-only access to listings</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div class="help-section-title">Dark / Light Mode</div>
                    <p style="font-size:0.875rem; color:var(--text-muted); margin:0;">Click the <i class="bi bi-sun"></i> / <i class="bi bi-moon"></i> button in the top-right of the topbar to toggle between dark and light mode. Your preference is saved automatically in the browser.</p>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="card mb-4" id="products">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-box-seam" style="color:#10b981;"></i>
                <h6 class="mb-0 fw-600">Managing Products</h6>
            </div>
            <div class="card-body px-4 py-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="help-section-title">Add a Product</div>
                        <div class="d-flex gap-2 mb-2"><span class="step-badge">1</span><span style="font-size:0.875rem;">Go to <a href="/admin/products/new">Products → New Product</a>.</span></div>
                        <div class="d-flex gap-2 mb-2"><span class="step-badge">2</span><span style="font-size:0.875rem;">Fill in Name, SKU, Category, Description, and Price fields.</span></div>
                        <div class="d-flex gap-2 mb-2"><span class="step-badge">3</span><span style="font-size:0.875rem;">Upload product images (supports multiple). Drag to reorder.</span></div>
                        <div class="d-flex gap-2"><span class="step-badge">4</span><span style="font-size:0.875rem;">Mark the product as Active and click <strong>Save Product</strong>.</span></div>
                    </div>
                    <div class="col-md-6">
                        <div class="help-section-title">Product Images</div>
                        <ul style="font-size:0.875rem; color:var(--text-muted); padding-left:1.25rem; margin:0;">
                            <li>Upload multiple images at once via the image uploader.</li>
                            <li>Drag and drop images to reorder them.</li>
                            <li>Click the <i class="bi bi-star"></i> icon to set a primary (thumbnail) image.</li>
                            <li>You can also add images by pasting a public URL.</li>
                            <li>Delete individual images using the <i class="bi bi-trash"></i> icon.</li>
                        </ul>
                    </div>
                    <div class="col-12">
                        <div class="help-section-title">Categories</div>
                        <p style="font-size:0.875rem; color:var(--text-muted); margin:0;">
                            Manage product categories under <a href="/admin/categories">Catalog → Categories</a>. Each category has a name, slug, and optional description. Products must be assigned a category. You can activate/deactivate categories without deleting them.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enquiries -->
        <div class="card mb-4" id="enquiries">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-envelope" style="color:#f59e0b;"></i>
                <h6 class="mb-0 fw-600">Managing Enquiries</h6>
            </div>
            <div class="card-body px-4 py-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="help-section-title">Enquiry Statuses</div>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-danger">New</span>
                                <span style="font-size:0.85rem; color:var(--text-muted);">Unread enquiry, shown as badge in sidebar</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-warning text-dark">Read</span>
                                <span style="font-size:0.85rem; color:var(--text-muted);">Opened and reviewed by admin</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success">Replied</span>
                                <span style="font-size:0.85rem; color:var(--text-muted);">Follow-up completed</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="help-section-title">Handling an Enquiry</div>
                        <div class="d-flex gap-2 mb-2"><span class="step-badge">1</span><span style="font-size:0.875rem;">Click any enquiry row to view its full details.</span></div>
                        <div class="d-flex gap-2 mb-2"><span class="step-badge">2</span><span style="font-size:0.875rem;">The status auto-changes to <strong>Read</strong> on open.</span></div>
                        <div class="d-flex gap-2"><span class="step-badge">3</span><span style="font-size:0.875rem;">Use the status dropdown to mark as <strong>Replied</strong> after follow-up.</span></div>
                    </div>
                    <div class="col-12">
                        <div class="alert mb-0 py-2 px-3" style="background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.3); border-radius:8px; font-size:0.85rem; color:var(--text-primary);">
                            <i class="bi bi-info-circle me-1" style="color:#f59e0b;"></i>
                            The red badge in the sidebar shows the count of <strong>New</strong> (unread) enquiries. It disappears when all are read.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Management -->
        <div class="card mb-4" id="content">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-layout-text-window" style="color:#ef4444;"></i>
                <h6 class="mb-0 fw-600">Content Management</h6>
            </div>
            <div class="card-body px-4 py-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="help-section-title">Home & About Content</div>
                        <p style="font-size:0.875rem; color:var(--text-muted);">
                            Edit the sections and items displayed on the public Home and About pages.
                            Each page has <strong>Sections</strong> (layout blocks) and <strong>Items</strong> (individual pieces of content within a section).
                            Use the Settings tab to control section visibility and display order.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="help-section-title">FAQ Content</div>
                        <p style="font-size:0.875rem; color:var(--text-muted);">
                            Manage FAQ categories and questions under <a href="/admin/faq">Content → FAQ</a>.
                            Create categories first, then add items to each.
                            Drag items to reorder them on the public page.
                        </p>
                    </div>
                    <div class="col-12">
                        <div class="help-section-title">Legal Pages (Privacy & Terms)</div>
                        <p style="font-size:0.875rem; color:var(--text-muted); margin:0;">
                            Edit the Privacy Policy and Terms &amp; Conditions pages under <a href="/admin/page-content/privacy">Content → Legal Pages</a>.
                            Content is saved as rich HTML and rendered directly on the public pages.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO & Media -->
        <div class="card mb-4" id="seo-media">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-search" style="color:#14b8a6;"></i>
                <h6 class="mb-0 fw-600">SEO & Media Library</h6>
            </div>
            <div class="card-body px-4 py-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="help-section-title">Page SEO</div>
                        <p style="font-size:0.875rem; color:var(--text-muted);">
                            Set the <strong>title tag</strong>, <strong>meta description</strong>, and <strong>OG image</strong> for each public page under <a href="/admin/page-seo">SEO & Media → Page SEO</a>.
                            Good meta descriptions are 120–160 characters. OG images should be 1200×630 px for social sharing.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="help-section-title">Media Library</div>
                        <p style="font-size:0.875rem; color:var(--text-muted);">
                            Upload, browse, and manage all site images from <a href="/admin/media">SEO & Media → Media Library</a>.
                            Use the <strong>Media Picker</strong> within content forms to insert previously uploaded images.
                            Deleted media is removed permanently from the server.
                        </p>
                    </div>
                    <div class="col-12">
                        <div class="help-section-title">Themes (Super Admin)</div>
                        <p style="font-size:0.875rem; color:var(--text-muted); margin:0;">
                            Switch the public site's visual theme from <a href="/admin/themes">Config → Themes</a>. Only one theme can be active at a time. The admin panel itself always uses its own dark/light toggle independently of the public theme.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div class="card mb-4" id="faq-admin">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-patch-question" style="color:#a855f7;"></i>
                <h6 class="mb-0 fw-600">Frequently Asked Questions</h6>
            </div>
            <div class="card-body p-0">
                <div class="accordion accordion-flush" id="helpAccordion">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How do I reset my admin password?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                Go to the <a href="/admin/login">login page</a> and click <strong>Forgot Password</strong>. Enter your registered email address and you'll receive a reset link valid for 1 hour. If you don't receive the email, check your spam folder or contact your super admin.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Why can't I access Settings or Themes?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                Settings and Themes are restricted to <strong>Super Admin</strong> role only. If you need access, ask your Super Admin to upgrade your account role. Regular manager/viewer accounts cannot modify system-level configuration.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What image formats are supported for uploads?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                The system accepts <strong>JPG, JPEG, PNG, WEBP, and GIF</strong> formats. For best performance, use WEBP or optimised JPG images. Images are automatically processed by the optimizer on upload. Keep individual file sizes under 5 MB.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How do I reorder products or categories?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                Products and categories have a <strong>Sort Order</strong> field in their edit forms. Enter a lower number to display an item earlier. For content sections and FAQ items, use the drag-and-drop handles (<i class="bi bi-grip-vertical"></i>) on the list page to reorder them visually.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                How do I update the site's meta title and description?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                Go to <a href="/admin/page-seo">SEO & Media → Page SEO</a>. Each public page (Home, About, Products, FAQ, etc.) has its own SEO settings. Click Edit next to a page, fill in the title, description, and OG image, then save.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                How do I deactivate a product without deleting it?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                Open the product's edit page, uncheck the <strong>Active</strong> toggle, and save. The product will be hidden from the public site but all its data (images, descriptions, SEO info) will remain intact. You can reactivate it at any time.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                The OTP for login is not arriving. What should I do?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                OTPs expire after <strong>10 minutes</strong>. If you haven't received the email: (1) Check your spam/junk folder. (2) Ensure your registered email is correct in the system. (3) Ask your Super Admin to verify the SMTP configuration under <a href="/admin/settings">Settings</a>. (4) Contact Ramras Technologies support if the issue persists.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Right Column — Contact & Quick Links -->
    <div class="col-lg-4">

        <!-- Contact Support -->
        <div class="card mb-4" style="border-radius:12px;">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-headset" style="color:var(--accent);"></i>
                <h6 class="mb-0 fw-600">Contact Support</h6>
            </div>
            <div class="card-body px-4 py-3 d-flex flex-column gap-3">

                <div class="contact-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="help-icon-box" style="background:rgba(99,102,241,0.15); color:#6366f1;">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--text-muted); margin-bottom:2px;">Email Support</div>
                            <a href="mailto:info@ramrastech.com" style="font-size:0.875rem; font-weight:500; color:var(--text-primary); text-decoration:none;">info@ramrastech.com</a>
                        </div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="help-icon-box" style="background:rgba(16,185,129,0.15); color:#10b981;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--text-muted); margin-bottom:2px;">Phone / WhatsApp</div>
                            <a href="tel:+917317377477" style="font-size:0.875rem; font-weight:500; color:var(--text-primary); text-decoration:none;">+91 73173 77477</a>
                        </div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="help-icon-box" style="background:rgba(245,158,11,0.15); color:#f59e0b;">
                            <i class="bi bi-globe"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--text-muted); margin-bottom:2px;">Website</div>
                            <a href="https://ramrastech.com" target="_blank" rel="noopener" style="font-size:0.875rem; font-weight:500; color:var(--text-primary); text-decoration:none;">ramrastech.com</a>
                        </div>
                    </div>
                </div>

                <div style="font-size:0.8rem; color:var(--text-muted); padding-top:0.25rem; border-top:1px solid var(--card-border);">
                    <i class="bi bi-clock me-1"></i> Support hours: Mon–Sat, 10am–7pm IST
                </div>
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="card mb-4" style="border-radius:12px;">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-list-ul" style="color:var(--accent);"></i>
                <h6 class="mb-0 fw-600">On This Page</h6>
            </div>
            <div class="card-body px-4 py-3">
                <a href="#getting-started" class="toc-link">Getting Started</a>
                <a href="#products" class="toc-link">Managing Products</a>
                <a href="#enquiries" class="toc-link">Managing Enquiries</a>
                <a href="#content" class="toc-link">Content Management</a>
                <a href="#seo-media" class="toc-link">SEO & Media Library</a>
                <a href="#faq-admin" class="toc-link">Frequently Asked Questions</a>
            </div>
        </div>

        <!-- System Info -->
        <div class="card" style="border-radius:12px;">
            <div class="card-header d-flex align-items-center gap-2 py-3 px-4">
                <i class="bi bi-info-circle" style="color:var(--accent);"></i>
                <h6 class="mb-0 fw-600">System Info</h6>
            </div>
            <div class="card-body px-4 py-3">
                <div class="d-flex flex-column gap-2" style="font-size:0.85rem;">
                    <div class="d-flex justify-content-between">
                        <span style="color:var(--text-muted);">Platform</span>
                        <span>Product Gallery</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color:var(--text-muted);">Framework</span>
                        <span>CodeIgniter 4</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color:var(--text-muted);">Database</span>
                        <span>MySQL</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color:var(--text-muted);">Developer</span>
                        <span>Ramras Technologies</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color:var(--text-muted);">Logged in as</span>
                        <span><?= esc(session()->get('admin_username')) ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
