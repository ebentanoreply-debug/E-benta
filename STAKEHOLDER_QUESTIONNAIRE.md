# E-Benta Stakeholder Questionnaire

**Date:** May 13, 2026  
**Project:** E-Benta Digital Marketplace Platform  
**Purpose:** Validate system requirements, gather stakeholder feedback, and ensure all features meet business objectives

---

## SECTION 1: BUSINESS OBJECTIVES & VISION

### 1.1 Primary Business Goals
- [ ] What is the primary target market for E-Benta? (Domestic/International/Regional)
- [ ] What is the main problem your platform solves?
  - [ ] Promote e-waste recycling
  - [ ] Facilitate device resale
  - [ ] Connect buyers and sellers
  - [ ] Provide environmental impact tracking
  - [ ] All of the above
  
### 1.2 Success Metrics
- [ ] What are your key performance indicators (KPIs) for Year 1?
  - Expected number of active users: _______________
  - Expected number of monthly transactions: _______________
  - Expected environmental impact (tons of e-waste diverted): _______________
  - Target revenue model: _______________

- [ ] How will success be measured?
  - [ ] User acquisition rate
  - [ ] Transaction volume
  - [ ] Environmental metrics
  - [ ] User satisfaction/NPS
  - [ ] Revenue
  - [ ] Other: _______________

### 1.3 Timeline & Milestones
- [ ] When do you plan to launch?
- [ ] What is your MVP (Minimum Viable Product) scope?
- [ ] What features are "Phase 2" (future enhancements)?

---

## SECTION 2: USER ROLES & PERMISSIONS

### 2.1 User Types
Confirm the following user types and their permissions:

**Buyers**
- [ ] Can browse available devices? (Yes/No)
- [ ] Can filter by: device type, brand, condition, price range? (Yes/No)
- [ ] Can make offers on devices? (Yes/No)
- [ ] Can cancel offers within grace period (30 min)? (Yes/No)
- [ ] Can report listings/sellers? (Yes/No)
- [ ] Can leave reviews? (Yes/No)
- [ ] Can message sellers? (Yes/No)
- [ ] Can view transaction history? (Yes/No)

**Sellers**
- [ ] Can list devices? (Yes/No)
- [ ] Can edit/update listings? (Yes/No)
- [ ] Can delete/withdraw listings? (Yes/No)
- [ ] Can accept/reject offers? (Yes/No)
- [ ] Can cancel accepted offers? (Yes/No - if yes, grace period?)
- [ ] Can mark pickup confirmed? (Yes/No)
- [ ] Can report buyers? (Yes/No)
- [ ] Can leave reviews? (Yes/No)
- [ ] Can track environmental impact of sold devices? (Yes/No)

**Admins**
- [ ] Full system access? (Yes/No)
- [ ] Can suspend/ban users? (Yes/No)
- [ ] Can remove listings? (Yes/No)
- [ ] Can moderate reports? (Yes/No)
- [ ] Can view analytics/reports? (Yes/No)
- [ ] Can manage device categories/brands/models? (Yes/No)
- [ ] Can manage system settings? (Yes/No)

### 2.2 Authentication & Security
- [ ] Should platform support: (Select all that apply)
  - [ ] Email/Password registration
  - [ ] Google OAuth2
  - [ ] Facebook login
  - [ ] Phone-based OTP
  - [ ] Other: _______________

- [ ] What are password requirements?
  - Minimum length: _______________
  - Complexity requirements: _______________

- [ ] Should users have 2-factor authentication (2FA)? (Yes/No)

---

## SECTION 3: DEVICE MARKETPLACE FEATURES

### 3.1 Device Catalog
**Current Implementation:**
- 21 device types
- 42 device brands
- 106 device models

**Questions:**
- [ ] Is this device catalog comprehensive for your market?
- [ ] Which device types are most important for your business?
- [ ] Should we add/remove any categories? _______________
- [ ] Should sellers be able to propose new brands/models? (Yes/No)
- [ ] Admin approval required for new brands/models? (Yes/No)

### 3.2 Device Listing Features
- [ ] What information should sellers provide for each device?
  - [ ] Device type, brand, model (required)
  - [ ] Condition (Excellent/Good/Fair/Poor)
  - [ ] Storage/RAM (for electronics)
  - [ ] Cosmetic condition
  - [ ] Functional status
  - [ ] Warranty info
  - [ ] Original accessories included
  - [ ] Photos/videos
  - [ ] Description/notes
  - [ ] Price
  - [ ] Other: _______________

- [ ] Should listings have:
  - [ ] Title auto-generated or seller-input? (Auto/Seller/Both)
  - [ ] Description character limit? (Yes/No - if yes, ___ characters)
  - [ ] Minimum number of photos required? (0/1/2/3/4/5)
  - [ ] Photo verification/moderation? (Yes/No)
  - [ ] Listing duration (expires after 30/60/90 days or never)? _______________

### 3.3 Device Condition Levels
- [ ] Are these condition levels appropriate?
  - [ ] Excellent (like new, minimal use)
  - [ ] Good (light use, minor wear)
  - [ ] Fair (moderate use, visible wear)
  - [ ] Poor (heavy use, significant wear)

- [ ] Should different conditions have price guidelines? (Yes/No)

### 3.4 Search & Discovery
- [ ] Which filters are essential?
  - [ ] Device type (Yes/No)
  - [ ] Brand (Yes/No)
  - [ ] Model (Yes/No)
  - [ ] Condition (Yes/No)
  - [ ] Price range (Yes/No)
  - [ ] Location/Distance (Yes/No)
  - [ ] Seller rating (Yes/No)
  - [ ] Posted date (Yes/No)
  - [ ] Other: _______________

- [ ] Should there be:
  - [ ] Full-text search? (Yes/No)
  - [ ] Advanced search? (Yes/No)
  - [ ] Saved searches? (Yes/No)
  - [ ] Search history? (Yes/No)
  - [ ] Search recommendations/suggestions? (Yes/No)

---

## SECTION 4: OFFERS & TRANSACTION MANAGEMENT

### 4.1 Offer Lifecycle (Current Implementation)
**Current Flow:**
1. Buyer submits offer
2. Seller accepts/rejects
3. Offer accepted → 30-minute grace period for buyer cancellation
4. After 30 min or pickup confirmed → cannot cancel
5. Offer completed when transaction finishes

**Questions:**
- [ ] Is this flow correct? (Yes/No)
- [ ] Should grace period be:
  - [ ] 30 minutes (current)
  - [ ] 1 hour
  - [ ] 24 hours
  - [ ] No grace period
  - [ ] Configurable per listing

- [ ] When offer is cancelled, should:
  - [ ] Listing return to "available"? (Yes/No)
  - [ ] Seller be notified? (Yes/No)
  - [ ] Buyer be charged a cancellation fee? (Yes/No - if yes, %)
  - [ ] Cancellation be recorded in history? (Yes/No)

### 4.2 Offer Pricing & Payment
- [ ] Should the platform:
  - [ ] Take a commission on each transaction? (Yes/No - if yes, %)
  - [ ] Charge listing fees? (Yes/No - if yes, amount)
  - [ ] Have premium seller tiers? (Yes/No)
  - [ ] Support buyer financing/installments? (Yes/No)

- [ ] Payment methods supported:
  - [ ] Cash on pickup (current)
  - [ ] Bank transfer
  - [ ] Credit/debit card
  - [ ] Digital wallet (GCash, PayMaya, etc.)
  - [ ] Cryptocurrency
  - [ ] Other: _______________

- [ ] Should the platform:
  - [ ] Hold funds in escrow? (Yes/No)
  - [ ] Process refunds automatically? (Yes/No)
  - [ ] Require payment proof from buyer? (Yes/No)

### 4.3 Meeting & Pickup Process
- [ ] How should meeting location be determined?
  - [ ] Seller's address
  - [ ] Buyer's address
  - [ ] Public/neutral location
  - [ ] Virtual meetup
  - [ ] Shipping/delivery

- [ ] Should the platform:
  - [ ] Suggest safe meeting locations? (Yes/No)
  - [ ] Provide safety guidelines? (Yes/No)
  - [ ] Track pickup confirmation? (Yes/No)
  - [ ] Send reminders before scheduled pickup? (Yes/No)
  - [ ] Facilitate remote inspection/verification? (Yes/No)

### 4.4 Dispute Resolution
- [ ] What disputes should be supported?
  - [ ] Item not as described
  - [ ] Item damaged on arrival
  - [ ] Item missing parts/accessories
  - [ ] Payment issues
  - [ ] Non-payment by buyer
  - [ ] Non-delivery by seller
  - [ ] Other: _______________

- [ ] Dispute resolution process:
  - [ ] Auto-mediation with AI
  - [ ] Human moderator review
  - [ ] Arbitration with neutral party
  - [ ] Escalation to admin
  - [ ] Refund guarantee period: ___ days

---

## SECTION 5: REVIEWS, RATINGS & TRUST

### 5.1 Review System
- [ ] Should reviews include:
  - [ ] Star rating (1-5)? (Yes/No)
  - [ ] Written feedback? (Yes/No)
  - [ ] Photos/evidence? (Yes/No)
  - [ ] Multiple categories (accuracy, communication, speed, condition)? (Yes/No)

- [ ] Who can leave reviews?
  - [ ] Only transaction participants? (Yes/No)
  - [ ] Only confirmed purchases? (Yes/No)
  - [ ] Within X days of transaction? (Yes/No - if yes, how many days? ___)

- [ ] Review moderation:
  - [ ] Auto-detect and flag suspicious reviews? (Yes/No)
  - [ ] Manual moderation? (Yes/No)
  - [ ] Allow sellers to dispute reviews? (Yes/No)
  - [ ] Remove fake/verified fake reviews? (Yes/No)

### 5.2 Seller Reputation
- [ ] Should sellers have:
  - [ ] Overall rating badge? (Yes/No)
  - [ ] Response time metrics? (Yes/No)
  - [ ] Transaction completion rate? (Yes/No)
  - [ ] Return rate? (Yes/No)
  - [ ] Verification badges (email, ID, phone)? (Yes/No)
  - [ ] Years on platform badge? (Yes/No)

- [ ] Should sellers be ranked?
  - [ ] Gold/Silver/Bronze tiers? (Yes/No)
  - [ ] Based on: rating, volume, time active, or combined? _______________

---

## SECTION 6: REPORTING & MODERATION

### 6.1 Report Types (Current Implementation)
**Current report reasons:**
- Inappropriate Content
- Misleading Description
- Not As Described
- Suspicious Activity
- Fake Listing
- Other

**Questions:**
- [ ] Are these report categories sufficient? (Yes/No)
- [ ] Should we add:
  - [ ] Spam (Yes/No)
  - [ ] Scam/Fraud (Yes/No)
  - [ ] Offensive Language (Yes/No)
  - [ ] Harassment (Yes/No)
  - [ ] Stolen Item (Yes/No)
  - [ ] Other: _______________

### 6.2 Moderation Process
- [ ] Current process:
  - Admin reviews report
  - Takes action (none, warning, remove content, suspend, ban, remove listing)
  - Notifies involved parties

**Questions:**
- [ ] Should platform:
  - [ ] Auto-flag content for review? (Yes/No)
  - [ ] Use AI/ML for content moderation? (Yes/No)
  - [ ] Have community flagging? (Yes/No)
  - [ ] Show moderation timeline to reporter? (Yes/No)
  - [ ] Appeal process for users? (Yes/No)

- [ ] Penalties for violations:
  - [ ] First warning: Informal notice?
  - [ ] Second violation: Temporary suspension (___ days)?
  - [ ] Third violation: Permanent ban?
  - [ ] Serious violations (fraud, stolen items): Immediate ban?

### 6.3 Moderation Tools
- [ ] Should admins have:
  - [ ] Bulk action capabilities? (Yes/No)
  - [ ] User activity logs? (Yes/No)
  - [ ] IP address tracking? (Yes/No)
  - [ ] Device fingerprinting? (Yes/No)
  - [ ] Suspension/ban management? (Yes/No)
  - [ ] Message templates for responses? (Yes/No)

---

## SECTION 7: ENVIRONMENTAL IMPACT TRACKING

### 7.1 Impact Logging (Current Implementation)
**Current fields tracked:**
- Device type
- Device category
- Material recovered (estimated)
- CO2 prevented
- Processing/Refurbishment timeline
- Certifications (for verified refurbished devices)

**Questions:**
- [ ] Is this data comprehensive? (Yes/No)
- [ ] Should we also track:
  - [ ] Water saved? (Yes/No)
  - [ ] Energy saved? (Yes/No)
  - [ ] Waste diverted from landfill (weight)? (Yes/No)
  - [ ] Reusable materials percentage? (Yes/No)
  - [ ] Recyclable materials percentage? (Yes/No)
  - [ ] Hazardous materials identification? (Yes/No)
  - [ ] Device lifespan extension? (Yes/No)
  - [ ] Other: _______________

### 7.2 Impact Reporting
- [ ] Should the platform provide:
  - [ ] Individual user impact reports? (Yes/No)
  - [ ] Seller impact certificates? (Yes/No)
  - [ ] Monthly/annual platform-wide reports? (Yes/No)
  - [ ] Public impact dashboard? (Yes/No)
  - [ ] Integration with environmental organizations? (Yes/No)
  - [ ] Carbon credit generation? (Yes/No)

### 7.3 Certifications & Standards
- [ ] Should processed devices have:
  - [ ] Refurbished certification? (Yes/No)
  - [ ] Environmental compliance certification? (Yes/No)
  - [ ] ISO 14001 certification? (Yes/No)
  - [ ] E-Stewards certification? (Yes/No)
  - [ ] Other standards: _______________

---

## SECTION 8: PERFORMANCE & SCALABILITY

### 8.1 Expected Scale
- [ ] Expected launch user base: _______________
- [ ] Expected Year 1 growth rate: _______________
- [ ] Expected Year 3 user base: _______________
- [ ] Peak concurrent users: _______________
- [ ] Expected peak transactions per day: _______________

### 8.2 Performance Requirements
- [ ] Page load time target: ___ seconds
- [ ] Search response time: ___ seconds
- [ ] Photo upload speed: ___ seconds
- [ ] System uptime requirement: ___% (e.g., 99.9%)
- [ ] Peak traffic handling: ___ users simultaneously

### 8.3 Geographic Distribution
- [ ] Should the platform:
  - [ ] Support multiple languages? (Yes/No - if yes, which: _______________)
  - [ ] Support multiple currencies? (Yes/No - if yes, which: _______________)
  - [ ] Have region-specific listings? (Yes/No)
  - [ ] Region-specific pricing? (Yes/No)
  - [ ] Regional moderation teams? (Yes/No)

---

## SECTION 9: INTEGRATION & TECHNICAL

### 9.1 Third-Party Integrations
- [ ] Should the platform integrate with:
  - [ ] Payment gateways? (Yes/No - which: _______________)
  - [ ] SMS provider? (Yes/No - for OTP/notifications)
  - [ ] Email service? (Yes/No)
  - [ ] Cloud storage? (Yes/No - which: _______________)
  - [ ] Analytics platforms? (Yes/No)
  - [ ] CRM system? (Yes/No)
  - [ ] Accounting software? (Yes/No)
  - [ ] Social media? (Yes/No - which: _______________)
  - [ ] Environmental databases? (Yes/No)
  - [ ] Other: _______________

### 9.2 Data & Privacy
- [ ] What data privacy standards apply?
  - [ ] GDPR (Europe)
  - [ ] CCPA (California)
  - [ ] Local data protection laws: _______________
  - [ ] Industry standards: _______________

- [ ] User data requirements:
  - [ ] Require ID verification? (Yes/No)
  - [ ] Address verification? (Yes/No)
  - [ ] Phone verification? (Yes/No)
  - [ ] Email verification? (Yes/No)
  - [ ] Background checks for sellers? (Yes/No)

### 9.3 API & Mobile
- [ ] Should platform have:
  - [ ] Public API? (Yes/No)
  - [ ] Mobile app (iOS)? (Yes/No)
  - [ ] Mobile app (Android)? (Yes/No)
  - [ ] Responsive web design? (Yes/No)
  - [ ] Progressive Web App (PWA)? (Yes/No)

---

## SECTION 10: BUSINESS & LEGAL

### 10.1 Terms & Conditions
- [ ] Platform policies needed:
  - [ ] Terms of Service (Yes/No)
  - [ ] Privacy Policy (Yes/No)
  - [ ] Community Guidelines (Yes/No)
  - [ ] Seller Agreement (Yes/No)
  - [ ] Buyer Protection Policy (Yes/No)
  - [ ] Device Warranty Policy (Yes/No)
  - [ ] Environmental Impact Reporting Standards (Yes/No)
  - [ ] Dispute Resolution Policy (Yes/No)
  - [ ] Return/Refund Policy (Yes/No)

### 10.2 Liability & Insurance
- [ ] Should the platform:
  - [ ] Have seller insurance requirements? (Yes/No)
  - [ ] Provide buyer protection guarantee? (Yes/No)
  - [ ] Require platform liability insurance? (Yes/No)
  - [ ] Have transaction insurance? (Yes/No)

### 10.3 Legal Compliance
- [ ] What certifications/compliance are needed?
  - [ ] E-commerce license: _______________
  - [ ] Environmental compliance: _______________
  - [ ] Consumer protection registration: _______________
  - [ ] Data protection authority registration: _______________
  - [ ] Business registration: _______________
  - [ ] Other: _______________

### 10.4 Dispute & Revenue Models
- [ ] Commission structure:
  - [ ] Flat per-transaction fee: _______________
  - [ ] Percentage-based: _______________
  - [ ] Tiered based on volume: _______________
  - [ ] Seller membership fees: _______________
  - [ ] Featured listing fees: _______________
  - [ ] Premium support fees: _______________

---

## SECTION 11: FUTURE ENHANCEMENTS

### 11.1 Phase 2 Features (After MVP)
- [ ] Priority order for these features:
  - [ ] Shipping/Delivery integration (Priority: High/Medium/Low)
  - [ ] Buyer financing (Priority: High/Medium/Low)
  - [ ] Auction system (Priority: High/Medium/Low)
  - [ ] Subscription/Rent model (Priority: High/Medium/Low)
  - [ ] Trade-in program (Priority: High/Medium/Low)
  - [ ] Marketplace bundles (Priority: High/Medium/Low)
  - [ ] AI recommendation engine (Priority: High/Medium/Low)
  - [ ] Video verification (Priority: High/Medium/Low)
  - [ ] White-label solution (Priority: High/Medium/Low)
  - [ ] B2B bulk purchasing (Priority: High/Medium/Low)
  - [ ] IoT device compatibility (Priority: High/Medium/Low)
  - [ ] Blockchain verification (Priority: High/Medium/Low)

### 11.2 New Features for Year 2
- [ ] What new capabilities should be added?
  _______________________________________________

---

## SECTION 12: TESTING & QUALITY ASSURANCE

### 12.1 Testing Requirements
- [ ] QA processes needed:
  - [ ] Automated testing (unit/integration/e2e)? (Yes/No)
  - [ ] Manual QA testing? (Yes/No)
  - [ ] Performance/load testing? (Yes/No)
  - [ ] Security testing? (Yes/No)
  - [ ] Accessibility testing? (Yes/No)
  - [ ] User acceptance testing (UAT)? (Yes/No)

### 12.2 Bug & Issue Tracking
- [ ] Should there be:
  - [ ] Public bug report system? (Yes/No)
  - [ ] Bug bounty program? (Yes/No)
  - [ ] Internal issue tracking? (Yes/No)
  - [ ] User feedback system? (Yes/No)
  - [ ] Feature request voting? (Yes/No)

### 12.3 Monitoring & Alerts
- [ ] Required monitoring:
  - [ ] Real-time error monitoring? (Yes/No)
  - [ ] Performance monitoring? (Yes/No)
  - [ ] User activity monitoring? (Yes/No)
  - [ ] Fraud detection system? (Yes/No)
  - [ ] Automated alerts for critical issues? (Yes/No)

---

## SECTION 13: STAKEHOLDER FEEDBACK

### 13.1 Current System Assessment
- [ ] What aspects of the current system work well?
  _______________________________________________

- [ ] What aspects need improvement?
  _______________________________________________

- [ ] What is NOT implemented that should be?
  _______________________________________________

### 13.2 Critical Issues & Blockers
- [ ] Are there any critical issues blocking launch?
  _______________________________________________

- [ ] Are there feature gaps that must be filled before launch?
  _______________________________________________

- [ ] What is your biggest concern about the platform?
  _______________________________________________

### 13.3 Timeline & Resources
- [ ] What is your realistic launch date? _______________
- [ ] Do you have the resources to support: (Check all that apply)
  - [ ] Full-time development team
  - [ ] Part-time development support
  - [ ] QA/Testing team
  - [ ] Customer support team
  - [ ] Marketing/Community management
  - [ ] Admin/Moderation team

- [ ] Budget for Year 1: _______________
- [ ] Dedicated project manager? (Yes/No)

### 13.4 Success Definition
- [ ] How will you measure if the platform is successful after 6 months?
  _______________________________________________

- [ ] What is your vision for E-Benta after 3 years?
  _______________________________________________

---

## SECTION 14: SIGN-OFF

**Stakeholder Name:** _______________  
**Title:** _______________  
**Organization:** _______________  
**Contact Email:** _______________  
**Phone:** _______________  

**Date Completed:** _______________  

**Signature:** _______________ (Digital confirmation)

---

## NOTES & ADDITIONAL FEEDBACK

_______________________________________________
_______________________________________________
_______________________________________________
_______________________________________________
_______________________________________________

---

## Questionnaire Administration

**Distributed By:** _______________  
**Received Date:** _______________  
**Reviewed By:** _______________  
**Review Date:** _______________  
**Action Items:** _______________________________________________

---

**END OF QUESTIONNAIRE**
