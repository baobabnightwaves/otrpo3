# API Testing Guide for Laravel REST API (Lab 6)

## Server Setup

The Laravel development server is running on: `http://localhost:8000`

## Step-by-Step Testing Instructions

### 1. Create a User Account

1. Open browser and navigate to: `http://localhost:8000/register`
2. Register a new user account
3. You will be automatically logged in

### 2. Generate API Token

1. Navigate to: `http://localhost:8000/dashboard`
2. Click "Create New Token" button
3. Enter a name for your token (e.g., "My API Token")
4. **IMPORTANT**: Copy the generated token immediately - you won't see it again!
5. The token will look something like: `eyJ0eXAiOiJKV1QiLCJhbGc...`

### 3. Test API Endpoints

Use the token in the `Authorization` header as: `Bearer YOUR_TOKEN_HERE`

## API Endpoints Reference

### Authentication

#### Get Current User
```
GET /api/user
Authorization: Bearer YOUR_TOKEN_HERE
```

---

### Cities API (Main Entity)

#### Get All Cities
```
GET /api/cities
Authorization: Bearer YOUR_TOKEN_HERE
```

**Response includes:**
- City data
- `friendsWithAuthor` field (boolean) - indicates if city owner is your friend

#### Get Single City
```
GET /api/cities/{id}
Authorization: Bearer YOUR_TOKEN_HERE
```

#### Create New City
```
POST /api/cities
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json

{
  "name": "Porto",
  "card_text": "Beautiful coastal city",
  "modal_title": "Porto City",
  "modal_text": "Porto is known for its port wine",
  "wiki_url": "https://en.wikipedia.org/wiki/Porto",
  "interesting_fact": "Porto is the second largest city in Portugal"
}
```

**Required fields:**
- `name` (string, max 255 chars)

**Optional fields:**
- `card_text` (string, max 500 chars)
- `modal_title` (string, max 255 chars)
- `modal_text` (text)
- `wiki_url` (valid URL)
- `interesting_fact` (string)

#### Update City
```
PUT /api/cities/{id}
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json

{
  "name": "Porto Updated",
  "card_text": "Updated description"
}
```

#### Delete City
```
DELETE /api/cities/{id}
Authorization: Bearer YOUR_TOKEN_HERE
```

---

### Comments API (Secondary Entity)

#### Get All Comments
```
GET /api/comments
Authorization: Bearer YOUR_TOKEN_HERE
```

**Response includes:**
- Comment data
- Related `city` object (id, name, card_text)
- Related `user` object (id, name)
- `friendsWithAuthor` field (boolean) - indicates if comment author is your friend

#### Get Single Comment
```
GET /api/comments/{id}
Authorization: Bearer YOUR_TOKEN_HERE
```

#### Create New Comment
```
POST /api/comments
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json

{
  "content": "This is a great city!",
  "city_id": 1
}
```

**Required fields:**
- `content` (string)
- `city_id` (integer, must exist in cities table)

**Note:** `user_id` is automatically set to the authenticated user

#### Update Comment
```
PUT /api/comments/{id}
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json

{
  "content": "Updated comment text"
}
```

**Authorization:** Only the comment author can update their own comments

#### Delete Comment
```
DELETE /api/comments/{id}
Authorization: Bearer YOUR_TOKEN_HERE
```

**Authorization:** Only the comment author can delete their own comments

---

## Testing with Postman

### Setup

1. Open Postman
2. Create a new Collection called "Laravel Lab6 API"
3. Add a Collection Variable:
   - Name: `token`
   - Value: (paste your generated token here)
   - Name: `base_url`
   - Value: `http://localhost:8000`

### Request Configuration

For each request:
1. Select HTTP method (GET, POST, PUT, DELETE)
2. Enter URL: `{{base_url}}/api/cities` (example)
3. Go to "Headers" tab
4. Add header:
   - Key: `Authorization`
   - Value: `Bearer {{token}}`
5. For POST/PUT requests, also add:
   - Key: `Content-Type`
   - Value: `application/json`
6. Go to "Body" tab → select "raw" → select "JSON"
7. Enter request body (for POST/PUT)

### Sample Test Sequence

1. **GET /api/user** - Verify authentication works
2. **GET /api/cities** - See all cities
3. **POST /api/cities** - Create a new city
4. **GET /api/cities/{id}** - View the created city
5. **POST /api/comments** - Add a comment to the city
6. **GET /api/comments** - See all comments with city data
7. **PUT /api/comments/{id}** - Update your comment
8. **PUT /api/cities/{id}** - Update the city
9. **DELETE /api/comments/{id}** - Delete the comment
10. **DELETE /api/cities/{id}** - Delete the city

---

## Testing with cURL (Windows PowerShell)

### Get All Cities
```powershell
curl -H "Authorization: Bearer YOUR_TOKEN" http://localhost:8000/api/cities
```

### Create City
```powershell
$headers = @{
    "Authorization" = "Bearer YOUR_TOKEN"
    "Content-Type" = "application/json"
}
$body = @{
    name = "Lisbon"
    card_text = "Capital of Portugal"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/cities" -Method Post -Headers $headers -Body $body
```

### Create Comment
```powershell
$headers = @{
    "Authorization" = "Bearer YOUR_TOKEN"
    "Content-Type" = "application/json"
}
$body = @{
    content = "Amazing city!"
    city_id = 1
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/comments" -Method Post -Headers $headers -Body $body
```

---

## Key Features Implemented

### ✅ Basic Level Requirements
- Laravel Passport generates tokens for each user
- GET methods implemented for Cities (main entity)
- GET methods implemented for Comments (secondary entity)

### ✅ Extended Level Requirements
- POST and PUT methods implemented for Cities
- POST and PUT methods implemented for Comments
- Comment responses include related City data
- Both resources include `friendsWithAuthor` field indicating friendship status
- Proper authentication and authorization

---

## Expected Response Examples

### GET /api/cities
```json
{
  "data": [
    {
      "id": 1,
      "name": "Lisbon",
      "coat_of_arms_image": null,
      "card_text": "Capital city",
      "modal_title": "Lisbon",
      "modal_text": "The capital of Portugal",
      "city_image": null,
      "wiki_url": "https://en.wikipedia.org/wiki/Lisbon",
      "interesting_fact": "Lisbon is one of the oldest cities in Europe!",
      "user_id": 1,
      "created_at": "2025-12-25T10:00:00.000000Z",
      "updated_at": "2025-12-25T10:00:00.000000Z",
      "deleted_at": null,
      "friendsWithAuthor": false
    }
  ]
}
```

### GET /api/comments
```json
{
  "data": [
    {
      "id": 1,
      "content": "Great city!",
      "user_id": 2,
      "city_id": 1,
      "created_at": "2025-12-25T10:05:00.000000Z",
      "updated_at": "2025-12-25T10:05:00.000000Z",
      "city": {
        "id": 1,
        "name": "Lisbon",
        "card_text": "Capital city"
      },
      "user": {
        "id": 2,
        "name": "John Doe"
      },
      "friendsWithAuthor": false
    }
  ]
}
```

---

## Troubleshooting

### "Unauthenticated" Error
- Make sure you're including the `Authorization: Bearer TOKEN` header
- Verify your token is correct and hasn't been revoked
- Check that the token hasn't expired

### "The given data was invalid" Error
- Check your request body format (must be valid JSON)
- Verify all required fields are present
- Check field validation rules

### 403 Unauthorized
- You're trying to update/delete a resource you don't own
- Only comment authors can modify their own comments

### 404 Not Found
- The requested resource doesn't exist
- Check the ID in your URL

---

## Notes

- The web interface (existing CRUD) and API work simultaneously
- The `friendsWithAuthor` field requires users to be friends (use web interface to add friends)
- Tokens can be managed from the dashboard at `/dashboard`
- All API routes require authentication via Passport tokens
