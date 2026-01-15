from pydantic import BaseModel, Field, EmailStr, validator
from datetime import datetime
from typing import Optional
import re

class ContactCreate(BaseModel):
    name: str = Field(..., min_length=1, max_length=255)
    email: EmailStr
    subject: str = Field(..., min_length=1, max_length=255)
    message: str = Field(..., min_length=1, max_length=2000)
    
    @validator('name', 'subject', 'message')
    def sanitize_input(cls, v):
        if not v or not v.strip():
            raise ValueError('Ce champ ne peut pas être vide')
        # Remove any HTML tags for XSS protection
        cleaned = re.sub(r'<[^>]*>', '', v)
        return cleaned.strip()
    
    class Config:
        json_schema_extra = {
            "example": {
                "name": "Jean Dupont",
                "email": "jean@example.com",
                "subject": "Demande de collaboration",
                "message": "Bonjour, je souhaite discuter d'un projet..."
            }
        }

class ContactResponse(BaseModel):
    id: str
    name: str
    email: str
    subject: str
    message: str
    created_at: datetime
    
    class Config:
        from_attributes = True

class ContactDB(BaseModel):
    name: str
    email: str
    subject: str
    message: str
    created_at: datetime = Field(default_factory=datetime.utcnow)
    ip_address: Optional[str] = None
    user_agent: Optional[str] = None
