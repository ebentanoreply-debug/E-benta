{{-- Eco Footer Partial --}}
<style>
    .eco-footer {
        background: linear-gradient(180deg, #0a1628 0%, #060e14 100%);
        color: #94a3b8;
        border-top: 1px solid rgba(13, 148, 136, 0.2);
        padding: 4rem 0 2rem;
        margin-top: 4rem;
        position: relative;
        overflow: hidden;
    }
    .eco-footer-social-btn {
        width: 40px; height: 40px; border-radius: 50%;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8; text-decoration: none; transition: all 0.3s ease; font-size: 1rem;
    }
    .eco-footer-badge-card {
        display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
        padding: 1rem 0.75rem; background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06); border-radius: 0.75rem;
    }
    .eco-footer-contact-chip {
        display: flex; align-items: flex-start; gap: 0.75rem;
        color: inherit; text-decoration: none;
        transition: color 0.2s ease;
    }
    .eco-footer-contact-chip:hover { color: #2dd4bf; }
    .eco-legal-link {
        color: #64748b; text-decoration: none; font-size: 0.82rem; font-weight: 600;
        transition: color 0.2s ease;
    }
    .eco-legal-link:hover { color: #2dd4bf; }

    @media (max-width: 767.98px) {
        .eco-footer { padding: 2.5rem 0 1.5rem; margin-top: 2rem; }
        .eco-footer-badge-card { padding: 0.65rem 0.5rem; font-size: 0.78rem; }
        .eco-footer-social-btn { width: 42px; height: 42px; font-size: 1.05rem; }
    }
</style>

<footer class="eco-footer">
    <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 900px; max-width: 100vw; height: 220px; background: radial-gradient(ellipse at top, rgba(13,148,136,0.18), transparent 70%); pointer-events: none;"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row g-4 g-lg-5 mb-5">
            {{-- Brand & Mission --}}
            <div class="col-lg-4 col-md-6 col-12">
                <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 1.15rem;">
                    <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(13,148,136,0.4);">
                        <i class="fas fa-leaf" style="color: #ffffff; font-size: 1.25rem;"></i>
                    </div>
                    <span style="font-size: 1.6rem; font-weight: 900; letter-spacing: -0.5px; background: linear-gradient(135deg, #ffffff 0%, #a5f3fc 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">E-Benta</span>
                </div>
                <p style="font-size: 0.92rem; line-height: 1.75; color: #94a3b8; margin-bottom: 1.25rem;">
                    The Philippines' premier circular economy platform for certified e-waste monetization, bulk electronic scrap trading, and verifiable zero-landfill recycling.
                </p>
                <div class="mb-4">
                    <span style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(13,148,136,0.12); border: 1px solid rgba(13,148,136,0.3); padding: 0.45rem 0.95rem; border-radius: 2rem; font-size: 0.8rem; color: #5eead4; font-weight: 700;">
                        <i class="fas fa-shield-halved"></i> Verified Zero-Landfill Initiative
                    </span>
                </div>
                <div class="mb-4 mb-lg-0">
                    <small style="display: block; color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Connect With Us</small>
                    <div style="display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap;">
                        <a href="#" class="eco-footer-social-btn" title="Facebook" onmouseover="this.style.background='#0d9488'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#94a3b8';"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="eco-footer-social-btn" title="Twitter / X" onmouseover="this.style.background='#06b6d4'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#94a3b8';"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="eco-footer-social-btn" title="Instagram" onmouseover="this.style.background='#ec4899'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#94a3b8';"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="eco-footer-social-btn" title="LinkedIn" onmouseover="this.style.background='#3b82f6'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#94a3b8';"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="eco-footer-social-btn" title="Discord" onmouseover="this.style.background='#10b981'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#94a3b8';"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
            </div>

            {{-- Marketplace Links --}}
            <div class="col-lg-2 col-md-3 col-6">
                <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Marketplace</h6>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                    <li><a href="{{ route('listings.index') }}" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-arrow-right me-2" style="font-size: 0.75rem; color: #0d9488;"></i>All Listings</a></li>
                    <li><a href="{{ route('listings.index', ['category' => 'Smartphone']) }}" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-mobile-screen me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Smartphones</a></li>
                    <li><a href="{{ route('listings.index', ['category' => 'Laptop']) }}" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-laptop me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Laptops & PCs</a></li>
                    <li><a href="{{ route('listings.index', ['category' => 'Tablet']) }}" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-tablet-screen-button me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Tablets</a></li>
                    <li><a href="{{ route('listings.index', ['condition' => 'non_functional']) }}" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-boxes-stacked me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Scrap Lots</a></li>
                </ul>
            </div>

            {{-- Platform Links --}}
            <div class="col-lg-2 col-md-3 col-6">
                <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Platform</h6>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                    <li><a href="{{ route('home') }}#process" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-bolt me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>How It Works</a></li>
                    <li><a href="{{ route('home') }}#calculator" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-calculator me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>CO₂ Estimator</a></li>
                    <li><a href="{{ route('home') }}#impact" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-chart-line me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>Eco Scoreboard</a></li>
                    <li><a href="{{ route('home') }}#faq" style="color: #94a3b8; text-decoration: none;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-circle-question me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>Help & FAQ</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div class="col-lg-4 col-md-6 col-12">
                <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Support & Contact</h6>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.88rem; margin-bottom: 1.5rem;">
                    <a href="mailto:support@e-benta.ph" class="eco-footer-contact-chip">
                        <i class="fas fa-envelope mt-1" style="color: #0d9488; font-size: 1rem;"></i>
                        <div>
                            <span style="display: block; color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Direct Support Email</span>
                            <span style="color: #e2e8f0; font-weight: 600;">support@e-benta.ph</span>
                        </div>
                    </a>
                    <div class="eco-footer-contact-chip">
                        <i class="fas fa-location-dot mt-1" style="color: #06b6d4; font-size: 1rem;"></i>
                        <div>
                            <span style="display: block; color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Service Coverage</span>
                            <span style="color: #e2e8f0; font-weight: 500;">Nationwide, Philippines</span>
                        </div>
                    </div>
                    <div class="eco-footer-contact-chip">
                        <i class="fas fa-clock mt-1" style="color: #f59e0b; font-size: 1rem;"></i>
                        <div>
                            <span style="display: block; color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Operating Hours</span>
                            <span style="color: #e2e8f0; font-weight: 500;">Mon – Sat: 8:00 AM – 6:00 PM PHT</span>
                        </div>
                    </div>
                </div>
                <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 0.85rem; padding: 1rem;">
                    <small style="color: #e2e8f0; font-weight: 700; display: block; margin-bottom: 0.5rem; font-size: 0.85rem;">Stay Updated on Drop-off Drives</small>
                    <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to E-Benta Eco Updates!');" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <input type="email" placeholder="Enter your email" required style="background: rgba(0,0,0,0.35); border: 1px solid rgba(13,148,136,0.3); border-radius: 0.55rem; color: #ffffff; font-size: 0.88rem; padding: 0.55rem 0.85rem; flex: 1 1 180px; min-height: 42px; outline: none;">
                        <button type="submit" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.55rem; font-weight: 800; font-size: 0.85rem; padding: 0.55rem 1.25rem; min-height: 42px; cursor: pointer;">Join</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Trust Badges --}}
        <div style="border-top: 1px solid rgba(255,255,255,0.08); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 1.25rem 0; margin-bottom: 2rem;">
            <div class="row g-2 g-md-3 text-center text-md-start align-items-stretch">
                <div class="col-6 col-md-3"><div class="eco-footer-badge-card"><i class="fas fa-id-card-clip" style="color: #0d9488; font-size: 1.25rem;"></i><span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">100% ID Verified</span></div></div>
                <div class="col-6 col-md-3"><div class="eco-footer-badge-card"><i class="fas fa-lock" style="color: #06b6d4; font-size: 1.25rem;"></i><span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">SSL Encrypted</span></div></div>
                <div class="col-6 col-md-3"><div class="eco-footer-badge-card"><i class="fas fa-recycle" style="color: #10b981; font-size: 1.25rem;"></i><span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">Zero-Landfill Aligned</span></div></div>
                <div class="col-6 col-md-3"><div class="eco-footer-badge-card"><i class="fas fa-truck-fast" style="color: #f59e0b; font-size: 1.25rem;"></i><span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">Doorstep Pickup</span></div></div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-3" style="font-size: 0.85rem;">
            <p class="mb-0" style="color: #64748b; font-size: 0.82rem; line-height: 1.6;">
                &copy; {{ date('Y') }} <strong>E-Benta</strong>. All Rights Reserved. Built for Sustainable Circular Innovation in the Philippines.
            </p>
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-2 gap-md-3 align-items-center">
                <a href="{{ route('home') }}#faq" class="eco-legal-link">Privacy</a>
                <a href="{{ route('home') }}#faq" class="eco-legal-link">Terms</a>
                <a href="{{ route('home') }}#faq" class="eco-legal-link">Standards</a>
                <a href="#" style="color: #2dd4bf; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.65rem; border-radius: 0.4rem; background: rgba(45,212,191,0.08);" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
                    <span>Top</span> <i class="fas fa-arrow-up"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
