<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="upt.png" type="image/x-icon">
<title>Student</title>
<link rel="stylesheet" href="css/style4.css">
</head>
<section>
  <div class="user-container">
    <div class="dropdown">
      <button class="dropbtn">
        <h1><?php echo $_SESSION['name']; ?></h1>
        <img src="arrow.png" alt="Meniu" class="arrow"> 
      </button>
      <div class="dropdown-content">
        <a href="#">Profil</a>
        <!-- Adaugă restul linkurilor aici -->
      </div>
    </div>
  </div>
</section>
</html>
