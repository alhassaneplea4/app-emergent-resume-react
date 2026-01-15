from datetime import datetime, timedelta
from collections import defaultdict
from typing import Dict, List
import logging

logger = logging.getLogger(__name__)

class RateLimiter:
    def __init__(self, max_requests: int = 5, window_minutes: int = 15):
        self.max_requests = max_requests
        self.window = timedelta(minutes=window_minutes)
        self.requests: Dict[str, List[datetime]] = defaultdict(list)
    
    def is_allowed(self, ip_address: str) -> bool:
        """
        Check if request from this IP is allowed
        Returns True if allowed, False if rate limit exceeded
        """
        now = datetime.utcnow()
        
        # Clean old requests outside the time window
        cutoff_time = now - self.window
        self.requests[ip_address] = [
            req_time for req_time in self.requests[ip_address]
            if req_time > cutoff_time
        ]
        
        # Check if limit exceeded
        if len(self.requests[ip_address]) >= self.max_requests:
            logger.warning(f"Rate limit exceeded for IP: {ip_address}")
            return False
        
        # Add current request
        self.requests[ip_address].append(now)
        return True
    
    def get_remaining_requests(self, ip_address: str) -> int:
        """Get number of remaining requests for this IP"""
        now = datetime.utcnow()
        cutoff_time = now - self.window
        
        recent_requests = [
            req_time for req_time in self.requests.get(ip_address, [])
            if req_time > cutoff_time
        ]
        
        return max(0, self.max_requests - len(recent_requests))

# Global rate limiter instance
rate_limiter = RateLimiter(max_requests=5, window_minutes=15)
