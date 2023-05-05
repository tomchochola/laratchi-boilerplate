#!/bin/bash

SERVER="http://localhost:8000"

# Login
http --session=session -f POST $SERVER/api/v1/auth/login email=testovaci@uzivatel.cz password=password

# Register
http --session=session -f POST $SERVER/api/v1/auth/register name=name email=testovaci@uzivatel.cz password=password locale=cs

# E-mail confirmation
http --session=session -f POST $SERVER/api/v1/email_verification/confirm email=testovaci@uzivatel.cz token=

# Logout
http --session=session -f POST $SERVER/api/v1/auth/logout

# Password forgot
http --session=session -f POST $SERVER/api/v1/password/forgot email=testovaci@uzivatel.cz

# Password reset
http --session=session -f POST $SERVER/api/v1/password/reset email=testovaci@uzivatel.cz password=password token=

# Password update
http --session=session -f POST $SERVER/api/v1/password/update password=password new_password=password

# Show me
http --session=session -f GET  $SERVER/api/v1/me/show

# Update me
http --session=session -f POST $SERVER/api/v1/me/update name=name email=testovaci@uzivatel.cz locale=cs

# Destroy me
http --session=session -f POST $SERVER/api/v1/me/destroy password=password
