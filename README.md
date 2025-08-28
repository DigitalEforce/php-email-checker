# 📧 Bulk Email Existence Checker (PHP)

A simple PHP web app that checks if up to **10 email addresses** really exist by:
- Validating format
- Looking up MX records
- Attempting SMTP handshake (`RCPT TO`)

⚠️ **Note:** Due to privacy rules, some providers (like Gmail, Yahoo, Outlook) may always return "unknown" even if the email does not exist. The **only 100% reliable way** is sending a verification email.

---

## 🚀 Features
- ✅ Bulk check (up to 10 emails at once)  
- ✅ Clean web interface  
- ✅ Shows results in a table with friendly icons  
- ✅ Simple PHP code, no external libraries  

---

## Example 

| Email                | Status         |
|----------------------|----------------|
| test@gmail.com       | ✅ Exists      |
| fake123@domain.com   | ❌ Not Exists  |
| hello@unknownhost.io | ⚠️ Unknown     |

---

## 🛠️ Installation

1. Clone this repo:
   ```bash
   git clone https://github.com/your-username/php-email-checker.git
   ```

2. Place in your PHP server (XAMPP, WAMP, or hosting).  
   Example (Windows WAMP):
   ```
   C:\wamp64\www\php-email-checker\
   ```

3. Open in browser:
   ```
   http://localhost/php-email-checker/index.php
   ```

---

## 📋 Usage
1. Enter up to **10 emails** (one per line)  
2. Click **Check Emails**  
3. See results: ✅ Exists / ❌ Not Exists / ⚠️ Unknown  

---

## ⚠️ Limitations
- Some big providers **block SMTP checks** → results may show as *unknown*.  
- This script should be used for **educational / personal projects**, not bulk marketing.  
- For production-grade validation, consider APIs like:
  - [Hunter.io](https://hunter.io)
  - [NeverBounce](https://neverbounce.com)
  - [ZeroBounce](https://www.zerobounce.net/)

---

## 👨‍💻 About
Created by **Naveed** 💻  
- GitHub: [DigitalEforce](https://github.com/DigitalEforce)  


---
