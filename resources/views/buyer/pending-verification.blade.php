@extends('layouts.app')

@section('title', 'Account Pending Verification')

@section('content')
@include('buyer.sidebar')
<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; overflow-y: auto; min-height: 100vh; transition: margin-left 0.3s ease, width 0.3s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <!-- Enhanced Header with Animation -->
    <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(52, 152, 219, 0.1) 100%); border-bottom: 1px solid rgba(13, 148, 136, 0.2); padding: 3rem 2rem; margin-bottom: 3rem; animation: slideInDown 0.6s ease;">
        <div class="container">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); padding: 1.2rem; border-radius: 1rem; box-shadow: 0 8px 25px rgba(13, 148, 136, 0.2); animation: float 3s ease-in-out infinite;">
                    <i class="fas fa-hourglass-half" style="font-size: 2.5rem; color: white;"></i>
                </div>
                <div>
                    <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2.5rem; letter-spacing: -0.5px;">Account Under Verification</h1>
                    <p style="color: #64748b; margin: 0.5rem 0 0 0; font-size: 1rem; font-weight: 500;">Your account is being reviewed by our E-Benta team</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Status Badge with Pulse Animation -->
                <div style="display: flex; justify-content: center; margin-bottom: 2.5rem;">
                    <span style="background: linear-gradient(135deg, rgba(241, 196, 15, 0.2), rgba(230, 126, 34, 0.2)); color: #f39c12; font-weight: 700; padding: 0.85rem 1.75rem; border-radius: 50px; border: 1px solid rgba(241, 196, 15, 0.4); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.15); display: inline-flex; align-items: center; gap: 0.75rem; animation: pulse-badge 2s ease-in-out infinite;">
                        <span style="width: 8px; height: 8px; background: #f39c12; border-radius: 50%; animation: pulse-dot 2s ease-in-out infinite;"></span>
                        PENDING REVIEW
                    </span>
                </div>

                <!-- Main Content Card -->
                <div style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 253, 250, 0.95) 100%); border: 1px solid rgba(13, 148, 136, 0.15); border-radius: 1.5rem; padding: 3rem; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08); margin-bottom: 2rem; backdrop-filter: blur(10px);">
                    
                    <!-- Welcome Message -->
                    <div style="text-align: center; margin-bottom: 3rem;">
                        <h2 style="color: var(--text-light); font-weight: 800; font-size: 2.2rem; margin-bottom: 1rem; letter-spacing: -0.5px;">Welcome to E-Benta!</h2>
                        <p style="color: #64748b; font-size: 1.05rem; margin: 0; line-height: 1.8; max-width: 550px; margin-left: auto; margin-right: auto;">
                            Thank you for joining our circular economy marketplace. We're reviewing your account to ensure the safety and integrity of our community.
                        </p>
                    </div>

                    <!-- Verification Steps -->
                    <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.06) 0%, rgba(52, 152, 219, 0.03) 100%); border: 1px solid rgba(13, 148, 136, 0.15); border-radius: 1.2rem; padding: 2.25rem; margin-bottom: 2.5rem; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.08);">
                        <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 2rem; font-size: 1.25rem; display: flex; align-items: center; gap: 0.75rem;">
                            <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.2), rgba(13, 148, 136, 0.1)); padding: 0.6rem 0.8rem; border-radius: 0.6rem; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-tasks" style="color: var(--light-green); font-size: 1.1rem;"></i>
                            </div>
                            What Happens Next
                        </h4>

                        <!-- Timeline Steps -->
                        <div style="position: relative; padding-left: 2.5rem;">
                            <!-- Step 1 -->
                            <div style="position: relative; margin-bottom: 2.5rem; padding-bottom: 2.5rem; border-left: 2px solid rgba(13, 148, 136, 0.25);">
                                <div style="position: absolute; left: -13px; top: 5px; width: 24px; height: 24px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 6px rgba(13, 148, 136, 0.15), 0 4px 12px rgba(13, 148, 136, 0.2);"></div>
                                <div>
                                    <h5 style="color: var(--light-green); font-weight: 700; margin: 0 0 0.6rem 0; font-size: 1.05rem;">1. Review Your Information</h5>
                                    <p style="color: #a4b8b5; margin: 0; font-size: 0.95rem; line-height: 1.6;">Our verification team reviews your registration details and profile information to ensure accuracy.</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div style="position: relative; margin-bottom: 2.5rem; padding-bottom: 2.5rem; border-left: 2px solid rgba(13, 148, 136, 0.25);">
                                <div style="position: absolute; left: -13px; top: 5px; width: 24px; height: 24px; background: linear-gradient(135deg, rgba(13, 148, 136, 0.5) 0%, rgba(13, 148, 136, 0.35) 100%); border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 6px rgba(13, 148, 136, 0.12), 0 4px 12px rgba(13, 148, 136, 0.15);"></div>
                                <div>
                                    <h5 style="color: var(--text-light); font-weight: 700; margin: 0 0 0.6rem 0; font-size: 1.05rem;">2. Ensure Compliance</h5>
                                    <p style="color: #a4b8b5; margin: 0; font-size: 0.95rem; line-height: 1.6;">We verify your details match our community guidelines and security standards.</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div style="position: relative; padding-bottom: 0;">
                                <div style="position: absolute; left: -13px; top: 5px; width: 24px; height: 24px; background: linear-gradient(135deg, rgba(13, 148, 136, 0.3) 0%, rgba(13, 148, 136, 0.2) 100%); border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 6px rgba(13, 148, 136, 0.08), 0 4px 12px rgba(13, 148, 136, 0.1);"></div>
                                <div>
                                    <h5 style="color: var(--text-light); font-weight: 700; margin: 0 0 0.6rem 0; font-size: 1.05rem;">3. Receive Approval</h5>
                                    <p style="color: #a4b8b5; margin: 0; font-size: 0.95rem; line-height: 1.6;">Once approved, you'll get full access to browse listings, make offers, and purchase items.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Footer -->
                        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid rgba(13, 148, 136, 0.15);">
                            <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.15), rgba(13, 148, 136, 0.08)); padding: 0.6rem 0.75rem; border-radius: 0.6rem; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock" style="color: var(--light-green); font-size: 1.1rem;"></i>
                            </div>
                            <span style="color: #64748b; font-size: 0.95rem;">
                                <strong style="color: var(--text-light);">Typical timeframe:</strong> 24-48 hours
                            </span>
                        </div>
                    </div>

                    <!-- Important Note with Better Styling -->
                    <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.08) 0%, rgba(52, 152, 219, 0.04) 100%); border-left: 4px solid #3498db; border-radius: 0.8rem; padding: 1.75rem; margin-bottom: 2.5rem; display: flex; gap: 1rem;">
                        <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1)); padding: 0.75rem; border-radius: 0.6rem; display: flex; align-items: center; justify-content: center; min-width: 44px; height: 44px; flex-shrink: 0;">
                            <i class="fas fa-info-circle" style="color: #3498db; font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <p style="color: var(--text-light); margin: 0; line-height: 1.7; font-weight: 500;">
                                <strong>While you wait:</strong> You can browse available listings and explore the marketplace. Once your account is approved, you'll be able to submit offers immediately.
                            </p>
                        </div>
                    </div>

                    <!-- Verification Progress Bar -->
                    <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.06) 0%, rgba(13, 148, 136, 0.03) 100%); border: 1px solid rgba(13, 148, 136, 0.15); border-radius: 1rem; padding: 1.75rem; margin-bottom: 2.5rem; text-align: center;">
                        <p style="color: #64748b; margin-bottom: 1.25rem; font-size: 0.95rem; font-weight: 600;">Verification Progress</p>
                        <div style="background: rgba(13, 148, 136, 0.1); border-radius: 50px; height: 10px; overflow: hidden; box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);">
                            <div style="background: linear-gradient(90deg, var(--light-green) 0%, #0d9488 50%, #06b6d4 100%); height: 100%; width: 45%; animation: progressBar 3s ease-in-out infinite; border-radius: 50px; box-shadow: 0 0 20px rgba(13, 148, 136, 0.4);"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                        <a href="{{ route('listings.index') }}" style="background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: white; border: none; padding: 1.1rem 1.5rem; border-radius: 0.9rem; text-decoration: none; font-weight: 700; text-align: center; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(13, 148, 136, 0.25); display: flex; align-items: center; justify-content: center; gap: 0.75rem; font-size: 1rem;" onmouseover="this.style.boxShadow='0 10px 30px rgba(13, 148, 136, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 6px 20px rgba(13, 148, 136, 0.25)'; this.style.transform='translateY(0)';">
                            <i class="fas fa-eye"></i> Browse Marketplace
                        </a>
                        <a href="{{ route('profile') }}" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.12), rgba(155, 89, 182, 0.08)); color: var(--text-light); border: 1.5px solid rgba(52, 152, 219, 0.25); padding: 1.1rem 1.5rem; border-radius: 0.9rem; text-decoration: none; font-weight: 700; text-align: center; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.08); display: flex; align-items: center; justify-content: center; gap: 0.75rem; font-size: 1rem;" onmouseover="this.style.boxShadow='0 8px 25px rgba(52, 152, 219, 0.15)'; this.style.transform='translateY(-2px)'; this.style.backgroundColor='rgba(52, 152, 219, 0.15)';" onmouseout="this.style.boxShadow='0 4px 15px rgba(52, 152, 219, 0.08)'; this.style.transform='translateY(0)'; this.style.backgroundColor='rgba(52, 152, 219, 0.12)';">
                            <i class="fas fa-user-circle"></i> View Profile
                        </a>
                    </div>

                    <!-- Support Footer -->
                    <div style="text-align: center; padding-top: 2rem; border-top: 1px solid rgba(46, 204, 113, 0.15);">
                        <p style="color: #a4b8b5; margin: 0 0 0.75rem 0; font-size: 0.95rem;">
                            <strong style="color: var(--text-light);">Questions or concerns?</strong>
                        </p>
                        <p style="color: #a4b8b5; margin: 0; font-size: 0.9rem;">
                            <a href="#" style="color: var(--light-green); text-decoration: none; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.color='#06b6d4';" onmouseout="this.style.color='var(--light-green)';">Check our FAQ</a> 
                            <span style="color: #a4b8b5;">•</span> 
                            <a href="#" style="color: var(--light-green); text-decoration: none; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.color='#06b6d4';" onmouseout="this.style.color='var(--light-green)';">Contact support</a>
                        </p>
                    </div>
                </div>

                <!-- Benefits Section -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 3rem;">
                    <!-- Benefit Card 1 -->
                    <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.04) 100%); border: 1px solid rgba(13, 148, 136, 0.2); border-radius: 1.2rem; padding: 2rem; text-align: center; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.08);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(13, 148, 136, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(13, 148, 136, 0.08)';">
                        <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.15), rgba(13, 148, 136, 0.08)); padding: 1rem; border-radius: 0.8rem; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.1);">
                            <i class="fas fa-shield-alt" style="font-size: 1.8rem; color: var(--light-green);"></i>
                        </div>
                        <h6 style="color: var(--text-light); font-weight: 700; margin-bottom: 0.75rem; font-size: 1.05rem;">Secure & Safe</h6>
                        <p style="color: #64748b; font-size: 0.9rem; margin: 0; line-height: 1.6;">
                            We verify all users to maintain a trustworthy marketplace experience.
                        </p>
                    </div>

                    <!-- Benefit Card 2 -->
                    <div style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.08) 0%, rgba(46, 204, 113, 0.04) 100%); border: 1px solid rgba(46, 204, 113, 0.2); border-radius: 1.2rem; padding: 2rem; text-align: center; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(46, 204, 113, 0.08);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(46, 204, 113, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(46, 204, 113, 0.08)';">
                        <div style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.15), rgba(46, 204, 113, 0.08)); padding: 1rem; border-radius: 0.8rem; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 4px 12px rgba(46, 204, 113, 0.1);">
                            <i class="fas fa-check-circle" style="font-size: 1.8rem; color: #2ecc71;"></i>
                        </div>
                        <h6 style="color: var(--text-light); font-weight: 700; margin-bottom: 0.75rem; font-size: 1.05rem;">Quality Assured</h6>
                        <p style="color: #64748b; font-size: 0.9rem; margin: 0; line-height: 1.6;">
                            All verified users have full access to premium marketplace features.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulse-badge {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    @keyframes pulse-dot {
        0%, 100% { box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.7); }
        50% { box-shadow: 0 0 0 8px rgba(243, 156, 18, 0); }
    }

    @keyframes progressBar {
        0% { width: 30%; }
        50% { width: 60%; }
        100% { width: 30%; }
    }
</style>

@endsection
