<?php
require_once('classes/database.php');
$con = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_genre'])) {
    $genreName = trim($_POST['genreName']);
    if (empty($genreName)) {
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Genre name is required.'
                });
            }, 100);
        </script>";
    } else {
        // Insert genre into database
        $stmt = $con->conn->prepare("INSERT INTO genres (genre_name) VALUES (?)");
        $stmt->bind_param("s", $genreName);
        if ($stmt->execute()) {
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Genre added successfully!'
                    }).then(() => {
                        window.location.href = 'admin_homepage.php';
                    });
                }, 100);
            </script>";
        } else {
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Could not add the genre. Please try again.'
                    });
                }, 100);
            </script>";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Correct Bootstrap Icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <title>Genres</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Library Management System (Admin)</a>
      <a class="btn btn-outline-light ms-auto" href="add_authors.php">Add Authors</a>
      <a class="btn btn-outline-light ms-2 active" href="add_genres.php">Add Genres</a>
      <a class="btn btn-outline-light ms-2" href="add_books.php">Add Books</a>
      <div class="dropdown ms-2">
        <button class="btn btn-outline-light dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle"></i> <!-- Bootstrap icon -->
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li>
              <a class="dropdown-item" href="profile.php">
                  <i class="bi bi-person-circle me-2"></i> See Profile Information
              </a>
            </li>
          <li>
            <button class="dropdown-item" onclick="updatePersonalInfo()">
              <i class="bi bi-pencil-square me-2"></i> Update Personal Information
            </button>
          </li>
          <li>
            <button class="dropdown-item" onclick="updatePassword()">
              <i class="bi bi-key me-2"></i> Update Password
            </button>
          </li>
          <li>
            <button class="dropdown-item text-danger" onclick="logout()">
              <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="container my-5 border border-2 rounded-3 shadow p-4 bg-light">

  <h4 class="mt-5">Add New Genre</h4>
  <form method="POST" action="add_genres.php">
    <div class="mb-3">
      <label for="genreName" class="form-label">Genre Name</label>
      <input type="text" class="form-control" id="genreName" name="genreName" required>
    </div>
    <button type="submit" class="btn btn-primary" name="add_genre">Add Genre</button>
  </form>
</div>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script> <!-- Add Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script> <!-- Correct Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
