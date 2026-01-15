import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from datetime import datetime
import os
import logging

logger = logging.getLogger(__name__)

class EmailSender:
    def __init__(self):
        self.smtp_host = "smtp.gmail.com"
        self.smtp_port = 587
        self.smtp_username = os.environ.get('SMTP_USERNAME', 'astronetgn@gmail.com')
        self.smtp_password = os.environ.get('SMTP_PASSWORD', '')
        self.from_email = self.smtp_username
        self.to_email = self.smtp_username
    
    def send_contact_email(self, name: str, email: str, subject: str, message: str) -> bool:
        """
        Send contact form email via Gmail SMTP
        Returns True if successful, False otherwise
        """
        try:
            # Create message
            msg = MIMEMultipart('alternative')
            msg['From'] = f"Portfolio Contact <{self.from_email}>"
            msg['To'] = self.to_email
            msg['Subject'] = f"Nouveau message - {subject}"
            
            # Email body
            email_body = f"""
Nouveau message de contact reçu :

Nom: {name}
Email: {email}
Sujet: {subject}

Message:
{message}

---
Envoyé depuis votre portfolio professionnel
Date: {datetime.now().strftime('%d/%m/%Y à %H:%M')}
            """
            
            # Attach plain text
            text_part = MIMEText(email_body, 'plain', 'utf-8')
            msg.attach(text_part)
            
            # Send email
            with smtplib.SMTP(self.smtp_host, self.smtp_port) as server:
                server.starttls()
                server.login(self.smtp_username, self.smtp_password)
                server.send_message(msg)
            
            logger.info(f"Email sent successfully for contact from {email}")
            return True
            
        except Exception as e:
            logger.error(f"Failed to send email: {str(e)}")
            return False

email_sender = EmailSender()
