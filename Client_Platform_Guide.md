# Platform Usage Guide

Welcome to the trading platform. This guide provides an overview of the key features available in both the User Dashboard and the Admin Control Panel.

---

## 1. User Dashboard Guide

The User Dashboard is the central hub for investors to manage their capital, connect with traders, and monitor their portfolio growth.

### 🔐 Getting Started & KYC
- **Registration:** Users sign up and immediately land on their dashboard.
- **Identity Verification (KYC):** For security and compliance, users must verify their identity. An alert banner will appear at the top of the dashboard until they submit their documents (ID, Passport, or Driver's License) via the **Verify Now** link.

### 💰 Funding & Withdrawals
- **Deposits:** Navigate to the **Deposit** section, choose a payment method (Crypto, Bank Transfer, etc.), and follow the instructions to fund the account. The balance updates automatically once the admin approves the transaction (or upon blockchain confirmation).
- **Withdrawals:** Users can request to withdraw available funds in the **Withdraw** section. They must provide their wallet address or bank details. All withdrawals require admin approval.

### 📈 Copy Trading & Investments
- **Trader Marketplace:** Located at `/traders`, users can browse verified, top-performing traders. They can filter by ROI, Drawdown, Strategy, and Risk Level.
- **Copying a Trader:** By clicking **Start Copying** on a trader's profile, a user's funds will automatically mirror that trader's activity based on the allocated amount.
- **Investment Plans:** Users can invest directly into predefined company plans via the **Invest** tab if they prefer structured returns over copy trading.

### 🤝 Referral Program
- **Refer a Friend:** Users have a unique referral link in the **Refer** section. When someone signs up and deposits using their link, the referrer automatically earns a percentage commission.

---

## 2. Admin Control Panel Guide

The Admin Dashboard is the nerve center of the platform. It allows you (the owner/manager) to oversee all operations, approve transactions, and manage user accounts.

### 👥 User Management
- **View All Users:** See a complete list of registered users, their balances, and their status.
- **Manual Adjustments:** You can manually credit or debit a user's account if needed (e.g., adding a bonus or correcting a balance).
- **Account Blocking:** Temporarily suspend or block users who violate platform terms.

### 🛡️ KYC & Verifications
- **Review KYC Applications:** When a user submits their identity documents, they appear in the **KYC Applications** tab. You can review the attached images and choose to **Approve** or **Reject** them. Approving them removes the restriction banner from the user's dashboard.

### 💳 Transaction Approvals
- **Manage Deposits:** All manual deposits will appear as *Pending*. Once you confirm receipt of the funds in your wallet or bank, click **Approve** to credit the user's dashboard balance.
- **Manage Withdrawals:** When a user requests a withdrawal, it appears here. You must manually send the funds to their provided address/bank, then mark the withdrawal as **Processed** in the admin panel so their balance is permanently deducted.

### 📊 Copy Trading Management
- **Manage Traders:** You can create, edit, or remove Master Traders that appear on the `/traders` page. 
- **Trader Metrics:** You can update a trader's ROI, win rate, and followers to keep their performance statistics looking attractive and accurate.
- **Featured & Verified Traders:** You can toggle whether a trader is "Featured" (showing up at the top of the page) or "Verified" (showing the green checkmark).

### ⚙️ System Settings
- **Platform Configuration:** Update the site name, logo, favicon, and contact email addresses.
- **Payment Methods:** Add or remove the crypto wallet addresses or bank details that users see when trying to deposit.

---
*If you need further technical assistance, please reach out to your development team.*
