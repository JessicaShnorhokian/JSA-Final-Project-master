<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/header.css">
    <title>Document</title>
</head>

<body>
    <header>
        <nav id="navbar">
            <div class="nav">
                <input type="checkbox" id="nav-check">
                <div class="nav-header">
                    <div class="nav-title">
                        Store Name
                    </div>

                </div>
                <div class="nav-btn">
                    <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
          </label>
                </div>
                
                <div class="search-container">
                    <form action="./result.php" method="post">
                        <input type="text" class="search-input" name="search" placeholder="Search">
                        <button class="search-button" type="submit" name="searchbutton">
                            Search
                        </button>
                    </form>
                    
                </div>
                <div class="nav-links">          
                    <a href="homepage.php" >Inventory</a>
                    <a href="customer.php" >Customer</a>
                    <a href="order.php" >Orders</a>
                    <a href="reports.php">Reports</a>
                    <a href="# ">Account</a>
        </div>
      </div>
    </nav>
    </header>
    <div class="main-body">
      
  