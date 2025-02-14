# **mrnewport/assessment**
A simple web app for creating, previewing, and sharing postcards. Users can enter recipient details, write a message, or upload an image as the postcard’s back. The app provides **real-time previews, a WYSIWYG editor, and shareable links**.

---

## **📌 Features**
- **Create Postcards** – Enter recipient details and a message.
- **Rich Text Editor** – Format messages with a WYSIWYG editor.
- **Image Upload** – Use a custom background for the postcard’s back.
- **Live Preview** – See updates instantly while editing.
- **Front/Back Toggle** – Switch between message and image views.
- **Save & Copy Link** – Store postcards and share via link.

---

## **🛠️ Installation**

### **1️⃣ Clone the Repository**
```sh
git clone https://github.com/mrnewport/assessment.git
cd assessment
```

### **2️⃣ Install Backend Dependencies**
```sh
composer install
```

### **3️⃣ Install Frontend Dependencies**
```sh
npm install
```

### **4️⃣ Set Up Environment**
Copy the example `.env` file:
```sh
cp .env.example .env
```
Then generate the app key:
```sh
php artisan key:generate
```

### **5️⃣ Set Up Database**
Configure your `.env` file with your database credentials, then run:
```sh
php artisan migrate
```

### **6️⃣ Set Up Storage**
```sh
php artisan storage:link
```

### **7️⃣ Run the Application**
Start the Laravel backend:
```sh
php artisan serve
```
Start the frontend build process:
```sh
npm run dev
```
Now, visit **http://127.0.0.1:8000** to use the app.

---

## **🔗 API Endpoints**
| Method | Endpoint             | Description                |
|--------|----------------------|----------------------------|
| `GET`  | `/api/cards/{id}`    | Fetch a saved postcard     |
| `POST` | `/api/cards`         | Create a new postcard      |
| `PUT`  | `/api/cards/{id}`    | Update an existing postcard |

To fetch a postcard via API:
```sh
curl -X GET http://127.0.0.1:8000/api/cards/1
```

---

## **📸 Image Upload**
- Uploaded images are stored in `storage/app/public/cards/`.
- Images are accessible via `/storage/cards/{filename}`.
- If images don’t display, ensure `php artisan storage:link` has been run.

---
