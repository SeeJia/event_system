# Event Management System

This is an event management system that allows users to register and log in. Users can view and add events to their cart, check out, and upload payment receipt files. Admins can add, update, view, and delete events, as well as update payment statuses.

## Features

### API Tools
- **Supabase API**

### Programming Languages
- **PHP**

### Functionality

1. **Main Page**
2. **User Section**
   - Register
   - Login
   - User Dashboard
   - Cart
   - Orders
   - Logout
3. **Admin Section**
   - Login
   - Admin Dashboard
   - Manage Events
   - Manage Orders
   - Logout
  
## Getting Started

1. **Supabase**
   - Register for an account at: [Supabase](https://supabase.com/)
   - Obtain your API key.
   - Replace the API key in the code with your obtained key.

2. **Create Tables in Supabase Database**
   - Create the following tables:
     - **admin**
     - **event**
     - **user**
     - **user_checkout**
     - **user_event_cart**

3. **Create Storage in Supabase**
   - Create the following storage:
     - **event_image**
     - **payment_receipt**
