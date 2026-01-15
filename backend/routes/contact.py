from fastapi import APIRouter, HTTPException, Request
from typing import List
import logging
from datetime import datetime

from models.contact import ContactCreate, ContactResponse, ContactDB
from utils.email_sender import email_sender
from utils.rate_limiter import rate_limiter

logger = logging.getLogger(__name__)

router = APIRouter(prefix="/api/contact", tags=["contact"])

# This will be injected from main server.py
db = None

def set_database(database):
    global db
    db = database

@router.post("", response_model=dict)
async def create_contact(contact_data: ContactCreate, request: Request):
    """
    Create a new contact message
    - Validates input data
    - Checks rate limiting
    - Stores in MongoDB
    - Sends email notification
    """
    try:
        # Get client IP
        client_ip = request.client.host if request.client else "unknown"
        
        # Check rate limiting
        if not rate_limiter.is_allowed(client_ip):
            raise HTTPException(
                status_code=429,
                detail="Trop de requêtes. Veuillez réessayer dans 15 minutes."
            )
        
        # Prepare document for MongoDB
        contact_doc = ContactDB(
            name=contact_data.name,
            email=contact_data.email,
            subject=contact_data.subject,
            message=contact_data.message,
            ip_address=client_ip,
            user_agent=request.headers.get('user-agent', 'unknown')
        )
        
        # Insert into MongoDB
        result = await db.contacts.insert_one(contact_doc.dict())
        contact_id = str(result.inserted_id)
        
        logger.info(f"Contact message saved with ID: {contact_id}")
        
        # Send email notification (non-blocking)
        email_sent = email_sender.send_contact_email(
            name=contact_data.name,
            email=contact_data.email,
            subject=contact_data.subject,
            message=contact_data.message
        )
        
        if not email_sent:
            logger.warning(f"Email notification failed for contact {contact_id}")
        
        return {
            "success": True,
            "message": "Message envoyé avec succès!",
            "id": contact_id
        }
        
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error creating contact: {str(e)}")
        raise HTTPException(
            status_code=500,
            detail="Une erreur s'est produite. Veuillez réessayer."
        )

@router.get("/messages", response_model=dict)
async def get_all_contacts(limit: int = 100, skip: int = 0):
    """
    Get all contact messages (admin endpoint)
    """
    try:
        # Get total count
        total = await db.contacts.count_documents({})
        
        # Get messages with pagination
        cursor = db.contacts.find().sort("created_at", -1).skip(skip).limit(limit)
        messages = await cursor.to_list(length=limit)
        
        # Convert ObjectId to string
        for msg in messages:
            msg['id'] = str(msg.pop('_id'))
        
        return {
            "messages": messages,
            "total": total,
            "limit": limit,
            "skip": skip
        }
        
    except Exception as e:
        logger.error(f"Error fetching contacts: {str(e)}")
        raise HTTPException(
            status_code=500,
            detail="Erreur lors de la récupération des messages"
        )
