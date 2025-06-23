<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PawfectMatch Admin</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      height: 100vh;
      background-color:rgb(185, 199, 194);
      background-image: url ();
      
      background-size: contain;
      background-repeat: no-repeat;
      background-position: bottom right;
      background-attachment: fixed;
    }

    .container {
      display: flex;
      width: 100%;
    }

   .sidebar {
  width: 300px;
  background-color: #3b5f51;
  color: white;
  padding: 25px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  font-family: 'Segoe UI', sans-serif;
}

   .sidebar .logo {
  font-size: 26px;
  font-weight: 800;
  margin-bottom: 30px;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  width: 100%;
  text-align: center;
  padding: 10px 0;
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
  color: #fcd34d;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}
    .sidebar .nav {
      list-style: none;
      width: 100%;
      padding: 0;

    }

    .sidebar .nav li {
  font-size: 17px;
  font-weight: 600;
  padding: 12px 14px;
  margin-bottom: 30px;
  border-radius: 28px;
  cursor: pointer;
  font-weight: bold;
  color: #ffffff;
  
  background-size: 200% 100%;
  background-position: right;
  transition: all 0.3s ease;
  text-shadow: 0 1px 1px rgba(0,0,0,0.2);
}

   .sidebar .nav li:hover {
  background-position: left;
  padding-left: 20px;
  color: #fcd34d;
  box-shadow: inset 2px 0 0 #fcd34d;
}
    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .topbar {
      height: 60px;
      background-color: #3b5f51;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      color: white;
      font-size: 22px;
      font-weight: bold;
    }

    .content-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-section {
      
      padding: 50px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(92, 9, 225, 0.2);
      width: 100%;
      max-width: 600px;
    }
 
  </style>

</head>




<body>
  
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">Admin Panel</h2>
      <ul class="nav">
        <li> 👥 User Management</li>
        <li> 🐾 Animal Management</li>
        <li> 📄 Adoption Management</li>
        <li> 👥 Users</li>
        <li> 💛 Donations</li>
        <li> 📊 Reports</li>
        <li> ⚙️ Settings</li>
         <li> 🔚 Logout</li>
      </ul>
    </aside>
    

    <!-- Main Content -->
    <div class="main">



    
      <!-- Topbar -->
       
      <header class="topbar">
        <div>PawfectMatch</div>
        
      </header>

      
        
         
        </section>
      </div>
    </div>
  </div>
</body>
</html>
