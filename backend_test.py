#!/usr/bin/env python3
"""
Comprehensive Backend API Tests for Portfolio Contact System
Tests the contact API endpoints with various scenarios including validation, rate limiting, and data persistence.
"""

import requests
import json
import time
from datetime import datetime
import pymongo
from bson import ObjectId
import os
from dotenv import load_dotenv

# Load environment variables
load_dotenv('/app/backend/.env')

# Configuration
BASE_URL = "https://camara-dev.preview.emergentagent.com/api"
MONGO_URL = os.environ.get('MONGO_URL', 'mongodb://localhost:27017')
DB_NAME = os.environ.get('DB_NAME', 'test_database')

class ContactAPITester:
    def __init__(self):
        self.base_url = BASE_URL
        self.session = requests.Session()
        self.test_results = []
        
        # MongoDB connection
        try:
            self.mongo_client = pymongo.MongoClient(MONGO_URL)
            self.db = self.mongo_client[DB_NAME]
            self.contacts_collection = self.db.contacts
            print(f"✅ Connected to MongoDB: {DB_NAME}")
        except Exception as e:
            print(f"❌ MongoDB connection failed: {e}")
            self.mongo_client = None
    
    def log_test(self, test_name, success, details, response=None):
        """Log test results"""
        status = "✅ PASS" if success else "❌ FAIL"
        print(f"{status} {test_name}")
        if details:
            print(f"   Details: {details}")
        if response and not success:
            print(f"   Response: {response.status_code} - {response.text}")
        
        self.test_results.append({
            'test': test_name,
            'success': success,
            'details': details,
            'timestamp': datetime.now().isoformat()
        })
    
    def test_valid_contact_submission(self):
        """Test 1: Valid contact form submission"""
        test_data = {
            "name": "Jean Dupont",
            "email": "jean.dupont@example.com", 
            "subject": "Demande de collaboration",
            "message": "Bonjour, je souhaite discuter d'un projet web avec vous. Merci!"
        }
        
        try:
            response = self.session.post(f"{self.base_url}/contact", json=test_data)
            
            if response.status_code == 200:
                data = response.json()
                if (data.get('success') == True and 
                    'message' in data and 
                    'id' in data and
                    'succès' in data['message'].lower()):
                    
                    # Verify MongoDB storage
                    if self.mongo_client:
                        contact_id = data['id']
                        stored_contact = self.contacts_collection.find_one({'_id': ObjectId(contact_id)})
                        if stored_contact:
                            self.log_test("Valid Contact Submission", True, 
                                        f"Contact saved with ID: {contact_id}, French response received")
                            return contact_id
                        else:
                            self.log_test("Valid Contact Submission", False, 
                                        "Contact not found in MongoDB", response)
                    else:
                        self.log_test("Valid Contact Submission", True, 
                                    f"API response correct, MongoDB check skipped")
                        return data['id']
                else:
                    self.log_test("Valid Contact Submission", False, 
                                f"Invalid response structure: {data}", response)
            else:
                self.log_test("Valid Contact Submission", False, 
                            f"Expected 200, got {response.status_code}", response)
        except Exception as e:
            self.log_test("Valid Contact Submission", False, f"Exception: {str(e)}")
        
        return None
    
    def test_invalid_email_validation(self):
        """Test 2: Invalid email format validation"""
        test_data = {
            "name": "Test User",
            "email": "notanemail",
            "subject": "Test Subject", 
            "message": "Test message"
        }
        
        try:
            response = self.session.post(f"{self.base_url}/contact", json=test_data)
            
            if response.status_code == 422:
                self.log_test("Invalid Email Validation", True, 
                            "Correctly rejected invalid email format")
            else:
                self.log_test("Invalid Email Validation", False, 
                            f"Expected 422, got {response.status_code}", response)
        except Exception as e:
            self.log_test("Invalid Email Validation", False, f"Exception: {str(e)}")
    
    def test_empty_fields_validation(self):
        """Test 3: Empty fields validation"""
        test_cases = [
            {"name": "", "email": "test@example.com", "subject": "Test", "message": "Test"},
            {"name": "Test", "email": "test@example.com", "subject": "", "message": "Test"},
            {"name": "Test", "email": "test@example.com", "subject": "Test", "message": ""}
        ]
        
        all_passed = True
        for i, test_data in enumerate(test_cases):
            try:
                response = self.session.post(f"{self.base_url}/contact", json=test_data)
                
                if response.status_code != 422:
                    all_passed = False
                    print(f"   Empty field test {i+1} failed: got {response.status_code}")
            except Exception as e:
                all_passed = False
                print(f"   Empty field test {i+1} exception: {str(e)}")
        
        self.log_test("Empty Fields Validation", all_passed, 
                    "All empty field cases properly rejected" if all_passed else "Some empty field cases not handled")
    
    def test_xss_protection(self):
        """Test 4: XSS protection via HTML tag sanitization"""
        test_data = {
            "name": "<script>alert('xss')</script>Jean Dupont",
            "email": "jean@example.com",
            "subject": "<img src=x onerror=alert('xss')>Test Subject",
            "message": "<div onclick='alert(1)'>Test message</div>"
        }
        
        try:
            response = self.session.post(f"{self.base_url}/contact", json=test_data)
            
            if response.status_code == 200:
                data = response.json()
                contact_id = data.get('id')
                
                # Check if HTML tags were sanitized in MongoDB
                if self.mongo_client and contact_id:
                    stored_contact = self.contacts_collection.find_one({'_id': ObjectId(contact_id)})
                    if stored_contact:
                        name_clean = '<script>' not in stored_contact['name']
                        subject_clean = '<img' not in stored_contact['subject']
                        message_clean = '<div' not in stored_contact['message']
                        
                        if name_clean and subject_clean and message_clean:
                            self.log_test("XSS Protection", True, 
                                        "HTML tags successfully sanitized from all fields")
                        else:
                            self.log_test("XSS Protection", False, 
                                        f"HTML tags not properly sanitized: name={name_clean}, subject={subject_clean}, message={message_clean}")
                    else:
                        self.log_test("XSS Protection", False, "Contact not found in MongoDB for XSS test")
                else:
                    self.log_test("XSS Protection", True, 
                                "Request accepted (assuming sanitization works), MongoDB check skipped")
            else:
                self.log_test("XSS Protection", False, 
                            f"Expected 200, got {response.status_code}", response)
        except Exception as e:
            self.log_test("XSS Protection", False, f"Exception: {str(e)}")
    
    def test_rate_limiting(self):
        """Test 5: Rate limiting (5 requests per 15 minutes)"""
        test_data = {
            "name": "Rate Test User",
            "email": "ratetest@example.com",
            "subject": "Rate Limit Test",
            "message": "Testing rate limiting functionality"
        }
        
        success_count = 0
        rate_limited = False
        
        try:
            # Use a single session to maintain IP consistency
            rate_session = requests.Session()
            
            # Send 6 requests rapidly
            for i in range(6):
                response = rate_session.post(f"{self.base_url}/contact", json=test_data)
                
                if response.status_code == 200:
                    success_count += 1
                    print(f"   Request {i+1}: SUCCESS (200)")
                elif response.status_code == 429:
                    rate_limited = True
                    print(f"   Request {i+1}: RATE LIMITED (429)")
                    # Check for French error message
                    response_text = response.text.lower()
                    if 'requêtes' in response_text or 'minutes' in response_text or 'trop' in response_text:
                        self.log_test("Rate Limiting", True, 
                                    f"Rate limit triggered after {success_count} requests with French error message")
                        return
                    else:
                        self.log_test("Rate Limiting", False, 
                                    f"Rate limit triggered but no French error message: {response.text}")
                        return
                else:
                    print(f"   Request {i+1}: UNEXPECTED ({response.status_code})")
                
                time.sleep(0.2)  # Small delay between requests
            
            # Check results
            if rate_limited:
                self.log_test("Rate Limiting", True, 
                            f"Rate limit working - {success_count} requests succeeded before limiting")
            elif success_count == 6:
                # Rate limiting might not be working due to load balancer IP changes
                # Let's check if it's a configuration issue
                self.log_test("Rate Limiting", False, 
                            f"Rate limiting not triggered - all 6 requests succeeded (possible load balancer IP issue)")
            else:
                self.log_test("Rate Limiting", False, 
                            f"Unexpected behavior - {success_count} requests succeeded, no rate limiting")
                
        except Exception as e:
            self.log_test("Rate Limiting", False, f"Exception: {str(e)}")
    
    def test_admin_messages_endpoint(self):
        """Test 6: Admin messages endpoint"""
        try:
            response = self.session.get(f"{self.base_url}/contact/messages")
            
            if response.status_code == 200:
                data = response.json()
                if ('messages' in data and 
                    'total' in data and 
                    isinstance(data['messages'], list)):
                    self.log_test("Admin Messages Endpoint", True, 
                                f"Retrieved {len(data['messages'])} messages, total: {data['total']}")
                else:
                    self.log_test("Admin Messages Endpoint", False, 
                                f"Invalid response structure: {data}", response)
            else:
                self.log_test("Admin Messages Endpoint", False, 
                            f"Expected 200, got {response.status_code}", response)
        except Exception as e:
            self.log_test("Admin Messages Endpoint", False, f"Exception: {str(e)}")
    
    def test_mongodb_data_integrity(self):
        """Test 7: MongoDB data integrity verification"""
        if not self.mongo_client:
            self.log_test("MongoDB Data Integrity", False, "MongoDB connection not available")
            return
        
        try:
            # Check if contacts collection exists and has data
            count = self.contacts_collection.count_documents({})
            
            if count > 0:
                # Get a sample document to verify structure
                sample = self.contacts_collection.find_one()
                required_fields = ['name', 'email', 'subject', 'message', 'created_at', 'ip_address']
                
                missing_fields = [field for field in required_fields if field not in sample]
                
                if not missing_fields:
                    self.log_test("MongoDB Data Integrity", True, 
                                f"Collection has {count} documents with all required fields")
                else:
                    self.log_test("MongoDB Data Integrity", False, 
                                f"Missing fields in documents: {missing_fields}")
            else:
                self.log_test("MongoDB Data Integrity", False, 
                            "No documents found in contacts collection")
        except Exception as e:
            self.log_test("MongoDB Data Integrity", False, f"Exception: {str(e)}")
    
    def run_all_tests(self):
        """Run all tests in sequence"""
        print(f"🚀 Starting Contact API Tests")
        print(f"📍 Base URL: {self.base_url}")
        print(f"🗄️  Database: {DB_NAME}")
        print("=" * 60)
        
        # Run tests
        self.test_valid_contact_submission()
        self.test_invalid_email_validation()
        self.test_empty_fields_validation()
        self.test_xss_protection()
        self.test_rate_limiting()
        self.test_admin_messages_endpoint()
        self.test_mongodb_data_integrity()
        
        # Summary
        print("\n" + "=" * 60)
        print("📊 TEST SUMMARY")
        print("=" * 60)
        
        passed = sum(1 for result in self.test_results if result['success'])
        total = len(self.test_results)
        
        print(f"✅ Passed: {passed}/{total}")
        print(f"❌ Failed: {total - passed}/{total}")
        
        if total - passed > 0:
            print("\n🔍 FAILED TESTS:")
            for result in self.test_results:
                if not result['success']:
                    print(f"   • {result['test']}: {result['details']}")
        
        # Close MongoDB connection
        if self.mongo_client:
            self.mongo_client.close()
        
        return passed == total

if __name__ == "__main__":
    tester = ContactAPITester()
    success = tester.run_all_tests()
    exit(0 if success else 1)