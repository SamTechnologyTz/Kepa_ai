# Kepa AI - Documentation  

**Version**: 1.0  
**Last Updated**: currently. 

## Introduction  

**Kepa AI** is an advanced text-to-video generator powered by artificial intelligence. It allows users to convert written content into dynamic, professional-quality videos effortlessly. This documentation provides detailed information about Kepa AI's features, API endpoints, and usage guidelines.  

---

## Key Features  

- **Text-to-Video Conversion**: Converts written scripts into videos with voiceovers, animations, and transitions.  
- **Customization**: Supports custom video templates, avatars, voices, and branding options.  
- **AI-Powered Avatars**: Integrate human-like avatars to deliver scripts.  
- **Voice Selection**: Choose from a variety of natural-sounding voices in multiple languages.  
- **Multi-Language Support**: Create videos in different languages for global reach.  
- **Render and Export**: High-quality video rendering with options for export.  

---

## API Overview  

Kepa AI provides a RESTful API that allows developers to integrate its features into their applications.  

### Base URL  
```plaintext  
https://api.kepa.ai/v1/  
```  

---

## Authentication  

All API requests must include an authentication token.  

### Authentication Header:  
```plaintext  
Authorization: Bearer YOUR_API_TOKEN  
```  

---

## Endpoints  

### 1. Create Video  
**Endpoint**:  
```plaintext  
POST /videos  
```  

**Description**:  
Create a new video project.  

**Request Body**:  
```json  
{  
  "name": "Project Name",  
  "slides": [  
    {  
      "speech": "Your script here",  
      "voice": "en-US-AriaNeural",  
      "avatar": "https://example.com/avatar.png"  
    }  
  ],  
  "tags": ["marketing", "tutorial"]  
}  
```  

**Response**:  
```json  
{  
  "id": "video12345",  
  "status": "created",  
  "render_url": "https://api.kepa.ai/v1/videos/render/video12345"  
}  
```  

---

### 2. Render Video  
**Endpoint**:  
```plaintext  
POST /videos/render/{video_id}  
```  

**Description**:  
Render the video after creation.  

**Response**:  
```json  
{  
  "status": "rendering",  
  "estimated_time": "5 minutes"  
}  
```  

---

### 3. Get Video Details  
**Endpoint**:  
```plaintext  
GET /videos/{video_id}  
```  

**Description**:  
Retrieve details about a video, including status and download links.  

**Response**:  
```json  
{  
  "id": "video12345",  
  "name": "Project Name",  
  "status": "completed",  
  "download_url": "https://example.com/video.mp4"  
}  
```  

---

### 4. Update Video  
**Endpoint**:  
```plaintext  
PATCH /videos/{video_id}  
```  

**Description**:  
Update video details such as name or script.  

**Request Body**:  
```json  
{  
  "name": "Updated Project Name"  
}  
```  

**Response**:  
```json  
{  
  "status": "updated"  
}  
```  

---

### 5. Delete Video  
**Endpoint**:  
```plaintext  
DELETE /videos/{video_id}  
```  

**Description**:  
Delete a video project.  

**Response**:  
```json  
{  
  "status": "deleted"  
}  
```  

---

## Error Codes  

| Code  | Description                          |  
|-------|--------------------------------------|  
| 400   | Bad Request - Invalid input          |  
| 401   | Unauthorized - Invalid API token     |  
| 404   | Not Found - Resource not found       |  
| 500   | Server Error - Contact support       |  

---

## SDK and Libraries  

SDKs for common programming languages are available for easier integration:  
- **PHP**  
- **Python**  
- **JavaScript**  

---

## Contact Support  

For assistance, contact our support team:  
- **Email**: support@kepa.ai  
- **Website**: [www.kepa.ai/support](https://www.kepa.ai/support)  

--- 

This documentation will evolve with new features and updates. Stay tuned!
